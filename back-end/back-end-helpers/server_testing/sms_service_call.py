import urllib

__author__ = 'kbsoft'

from twisted.internet import reactor
from twisted.web.client import Agent
from twisted.web.http_headers import Headers
from twisted.internet.defer import succeed
from twisted.web.iweb import IBodyProducer

from zope.interface import implements


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


web_agent = Agent(reactor)

# for reference https://gist.github.com/lukemarsden/846545
urlEncodedData = urllib.urlencode({'mobile_number': '0711661919', 'message': 'Data'})
body = StringProducer(urlEncodedData)

d = web_agent.request('POST', 'http://127.0.0.1:3000/sms_service/',
                  Headers({'User-Agent': ['Knnect network testing client'],
                           'Content-Type': ['application/x-www-form-urlencoded']}), body)


def cbResponse(ignored):
    print(ignored)


# d.addCallback(cbResponse)


def cbShutdown(ignored):
    reactor.stop()


# d.addBoth(cbShutdown)

reactor.run()