__author__ = 'kbsoft'

import json
import time
import cgi
from datetime import datetime, timedelta

from twisted.web import http
from twisted.web.resource import Resource
from twisted.web.server import Site
from twisted.internet import reactor

from pymongo import MongoClient
from pymongo import GEOSPHERE

from config import config


class History(object, Resource):
    isLeaf = True

    def render_POST(self, request):
        # print "DEBUG: Got POST a request from {}".format(request.getClientIP())
        # global debugObject
        # reactor.callLater(2,reactor.stop)
        # debugObject = request
        content = cgi.escape(request.content.read())
        content_dict = json.loads(content)

        content_dict['id'] = int(content_dict['id'])
        content_dict['properties']['cabId'] = int(content_dict['properties']['cabId'])
        timestamp = float(content_dict['properties']['timeStamp'])
        timestamp_object = datetime.utcfromtimestamp(timestamp)
        timestamp_in_local = timestamp_object + timedelta(hours=5, minutes=30)
        content_dict['properties']['timeStamp'] = timestamp_in_local

        if content_dict['properties']['orderId']:
            content_dict['properties']['orderId'] = int(content_dict['properties']['orderId'])

        # print(content_dict)
        self.insert_to_mongo_DB(content_dict)

        request.responseHeaders.addRawHeader(b"content-type", b"application/json")
        timestamp = int(time.time())
        return_value = {
            u'result': u'true',
            u'timestamp': timestamp,
            u'status': u'sent',
            u'refid': u'N/A',
        }
        return json.dumps(return_value)

    def insert_to_mongo_DB(self, geojson_hash, database=config.api['db_name'], collection=config.api['db_collection']):
        return Service.db_client[database][collection].insert(geojson_hash)


class Service(Resource):
    # isLeaf = True
    debugMode = False
    db_client = None

    def __init__(self, debugMode, db_client):
        Resource.__init__(self)
        Service.debugMode = debugMode
        Service.db_client = db_client

    def getChild(self, path, request):
        if path == "history":
            return History()  # Get the next URL component
        else:
            return UnknownService()

    def render_GET(self, request):
        request.responseHeaders.addRawHeader(b"content-type", b"application/json")
        return_value = {u'result': u'ok'}
        return json.dumps(return_value)

    def restart(self):
        pass


class UnknownService(Resource):
    isLeaf = True

    def render(self, request):
        return self.error_info(request)

    def error_info(self, request):
        request.responseHeaders.addRawHeader(b"content-type", b"application/json")
        request.setResponseCode(http.NOT_FOUND)
        return_value = {
            u'result': u'false',
            u'reason': u'Unknown Service',
            u'request': {
                u'args': request.args,
                u'client': {
                    u'host': request.client.host,
                    u'port': request.client.port,
                    u'type': request.client.type,
                },
                u'code': request.code,
                u'method': request.method,
                u'path': request.path,
            }
        }
        return json.dumps(return_value)


def main():
    port = config.api['port']
    service_name = config.api['service_name']
    debug_mode = config.api['debug']
    db_host = config.api['db_host']
    db_port = config.api['db_port']

    db_client = MongoClient(db_host, db_port)
    resource = Service(debug_mode, db_client)
    root_web = Site(resource)
    resource.putChild(service_name, Service(debug_mode, db_client))

    if not debug_mode:
        db_client[config.api['db_name']][config.api['db_collection']].create_index([('location', GEOSPHERE)])
        print("Server starting...")
    else:
        print("DEBUG_MODE enabled!")

    reactor.listenTCP(port, root_web)
    print "Server running on {} url: localhost:{}/{}".format(port, port, service_name)
    reactor.run()


if __name__ == '__main__':
    main()