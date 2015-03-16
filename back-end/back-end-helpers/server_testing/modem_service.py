from twisted.internet.task import deferLater
from twisted.web.server import Site
from twisted.internet import reactor
from twisted.web.resource import Resource
import cgi

import sys, logging

from gsmmodem.modem import GsmModem, SentSms
from gsmmodem.exceptions import TimeoutException, PinRequiredError, IncorrectPinError


def initModem(port='/dev/ttyUSB1', baud=460800):
    global modem

    modem = GsmModem(port, baud)

    # Uncomment the following line to see what the modem is doing:
    # logging.basicConfig(format='%(levelname)s: %(message)s', level=logging.DEBUG)

    print('Connecting to GSM modem on {0}...'.format(port))
    try:
        modem.connect()
    except PinRequiredError:
        sys.stderr.write('Error: SIM card PIN required. Please specify a PIN. \n')
        sys.exit(1)
    except IncorrectPinError:
        sys.stderr.write('Error: Incorrect SIM card PIN entered.\n')
        sys.exit(1)
    print('Checking for network coverage...')
    try:
        modem.waitForNetworkCoverage(5)
    except TimeoutException:
        print('Network signal strength is not sufficient, please adjust modem position/antenna and try again.')
        modem.close()
        sys.exit(1)

initModem()

#
# def sendSms(destination, message, deliver=False):
#     if deliver:
#         print ('\nSending SMS and waiting for delivery report...')
#     else:
#         print('\nSending SMS \nmessage ({}) \nto ({})...'.format(message, destination))
#     try:
#         sms = modem.sendSms(destination, message, waitForDeliveryReport=deliver)
#     except TimeoutException:
#         print('Failed to send message: the send operation timed out')
#     else:
#         if sms.report:
#             print('Message sent{0}'.format(
#                 ' and delivered OK.' if sms.status == SentSms.DELIVERED else ', but delivery failed.'))
#         else:
#             print('Message sent.')
#
#
# debugObject = None
#
#
# class Modem_service(Resource):
#     isLeaf = True
#
#     def render_GET(self, request):
#         # reactor.callLater(2, reactor.stop)
#         print "Got a GET request from {}".format(request.getClientIP())
#         print(request.args)
#         return "<html><body><p>REST SMS service</p>Params are <b>mobile_number</b> and <b>message</b></body></html>"
#
#     def render_POST(self, request):
#         print "Got POST a request from {}".format(request.getClientIP())
#         print(request.args)
#         return "Not sported"
#
# port = 5000
#
# mode_flag_file = open("debug_mode", "r")
# mode_flag = int(mode_flag_file.readline())
#
# root = Resource()
# root.putChild('modem_service', Modem_service())
# site = Site(root)
#
# print "Starting server on {} url: 127.0.0.1:{}/modem_service".format(port, port)
# if not mode_flag == 1:
#     initModem()
#     print("Connected to modem")
# else:
#     print("DEBUG_MODE enabled no message will be sent out from the dongle")
#
# reactor.listenTCP(port, site)
# reactor.run()
