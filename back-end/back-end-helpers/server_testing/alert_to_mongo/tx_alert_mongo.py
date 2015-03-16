import datetime
from twisted.web.http_headers import Headers
from twisted.web.client import Agent
from pymongo import MongoClient
from twisted.internet.defer import inlineCallbacks
from twisted.web.resource import Resource
from twisted.web.server import Site
from twisted.internet import reactor

import cgi

import serial
import time
import json
import urllib

from twisted.internet.defer import succeed
from twisted.web.iweb import IBodyProducer

from zope.interface import implements

# Good article http://pedrokroger.net/getting-started-pycharm-python-ide/

# client = MongoClient() #will connect on the default host and port.
# We can also specify the host and port explicitly, as
# follows.
# Or use the MongoDB URI format
client = MongoClient('localhost', 27017)

debugObject = None

# For reference https://twistedmatrix.com/documents/14.0.0/web/howto/client.html
class StringProducer(object):
    implements(IBodyProducer)

    def __init__(self, body):
        self.body = body
        self.length = len(body)

    def startProducing(self, consumer):
        consumer.write(self.body)
        return succeed(None)

    def pauseProducing(self):
        pass

    def stopProducing(self):
        pass


class AlertToMongo(Resource):
    isLeaf = True

    def render_GET(self, request):
        print "Got a GET request from {}".format(request.getClientIP())
        return "<html><body><p>Not a valid request</p></body></html>"

    def render_POST(self, request):
        print "Got a POST request from {}".format(request.getClientIP())

        request_content = request.content.getvalue()
        json_content = json.loads(request_content)

        print("Request content {}".format(json_content))

        result = self.update_alert(json_content)

        print(result)

        return ""

    def update_alert(self, jsonHash, collection='live'):
        event_state = str(jsonHash['properties']['state'])
        order_id = int(jsonHash['properties']['orderId'])
        cab_id = int(jsonHash['properties']['cabId'])

        order_state = event_state

        client.track['cabs'].update({
                                        'cabId': cab_id
                                    },
                                    {
                                        '$set': {
                                            'state': order_state, "lastUpdatedOn": datetime.datetime.utcnow()
                                        }
                                    },
                                    upsert=False, multi=False)

        if event_state == "IDLE":
            order_state = "COMPLETED"
        elif event_state == "AT_THE_PLACE":
            order = client.track['live'].find_one({'refId': order_id})
            self.send_sms(order['tp'], "Your cab is at the place,\nRefNo: {} \nThank you".format(order_id))

        print(
            "DEBUG: orderId = {} orderState = {}".format(order_id,
                                                         event_state))  # client.track['users'].update() #TODO: update cab status as-well

        client.track[collection].update({
                                            'refId': order_id
                                        },
                                        {
                                            '$set': {
                                                'status': order_state, "lastUpdatedOn": datetime.datetime.utcnow()
                                            }
                                        },
                                        upsert=False, multi=False)
        if event_state == "IDLE":
            current_order = client.track[collection].find_one({'refId': order_id})
            client.track['history'].save(current_order)
            client.track[collection].remove({'refId': order_id})

    @inlineCallbacks
    def send_sms(self, mobile_number, message):
        # for reference https://gist.github.com/lukemarsden/846545
        urlEncodedData = urllib.urlencode({'mobile_number': mobile_number, 'message': message})
        body = StringProducer(urlEncodedData)

        yield web_agent.request('POST', 'http://127.0.0.1:3000/sms_service/',
                                Headers({'User-Agent': ['Knnect network testing client'],
                                         'Content-Type': ['application/x-www-form-urlencoded']}), body)


port = 9091

web_agent = Agent(reactor)

root = Resource()
root.putChild('alert_mongo', AlertToMongo())
site = Site(root)
print "Starting server on {}".format(port)

reactor.listenTCP(port, site)
reactor.run()
