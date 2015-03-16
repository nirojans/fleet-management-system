#!/usr/bin/env python
"""
sms.py - Used to send txt messages.
"""
import serial
import time

class TextMessage:
    def __init__(self, recipient="0711661919", message="Testing message from Kasun"):
        self.recipient = recipient
        self.content = message

    def setRecipient(self, number):
        self.recipient = number

    def setContent(self, message):
        self.content = message

    def connectPhone(self):
        self.ser = serial.Serial('/dev/ttyUSB0', 460800, timeout=5)
        time.sleep(1)

    def sendMessage(self):
        print "Sending SMS....."
        self.ser.write('ATZ\r')
        time.sleep(1)
        self.ser.write('AT+CMGF=1\r')
        time.sleep(1)
        self.ser.write('''AT+CMGS="''' + self.recipient + '''"\r''')
        time.sleep(1)
        self.ser.write(self.content + "\r")
        time.sleep(1)
        self.ser.write(chr(26))
        time.sleep(1)
        print "Done. You should have receive the message by now!"

    def disconnectPhone(self):
        self.ser.close()

def main():
	sampleMessage = TextMessage()
	sampleMessage.connectPhone()
	sampleMessage.sendMessage()
main()

if __name__=='main':
	main()
