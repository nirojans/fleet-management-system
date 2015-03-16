#!/usr/bin/env python
"""
sms.py - Used to send txt messages.
@dependency  sudo pip install python-gsmmodem
"""
import serial
import time
import sys, logging

from gsmmodem.modem import GsmModem, SentSms
from gsmmodem.exceptions import TimeoutException, PinRequiredError, IncorrectPinError


def main():
    port = '/dev/ttyUSB0'
    baud = 460800
    deliver = False
    destination = "0711661919"
    message = "Testing_message \n new line \t tab \n n \n e \n l"
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
    else:
        print('\nPlease type your message and press enter to send it:')
        text = message
        if deliver:
            print ('\nSending SMS and waiting for delivery report...')
        else:
            print('\nSending SMS message...')
        try:
            sms = modem.sendSms(destination, text, waitForDeliveryReport=deliver)
        except TimeoutException:
            print('Failed to send message: the send operation timed out')
            modem.close()
            sys.exit(1)
        else:
            modem.close()
            if sms.report:
                print('Message sent{0}'.format(
                    ' and delivered OK.' if sms.status == SentSms.DELIVERED else ', but delivery failed.'))
            else:
                print('Message sent.')


if __name__ == '__main__':
    main()

# class TextMessage:
# def __init__(self, recipient="0711661919", message="Testing message from Kasun"):
# self.recipient = recipient
#         self.content = message
#
#     def setRecipient(self, number):
#         self.recipient = number
#
#     def setContent(self, message):
#         self.content = message
#
#     def connectPhone(self):
#         self.ser = serial.Serial('/dev/ttyUSB_utps_modem', 460800, timeout=5)
#         time.sleep(1)
#
#     def sendMessage(self):
#         print "Sending SMS....."
#         self.ser.write('ATZ\r')
#         time.sleep(1)
#         self.ser.write('AT+CMGF=1\r')
#         time.sleep(1)
#         self.ser.write('''AT+CMGS="''' + self.recipient + '''"\r''')
#         time.sleep(1)
#         self.ser.write(self.content + "\r")
#         time.sleep(1)
#         self.ser.write(chr(26))
#         time.sleep(1)
#         print "Done. You should have receive the message by now!"
#
#     def disconnectPhone(self):
#         self.ser.close()
