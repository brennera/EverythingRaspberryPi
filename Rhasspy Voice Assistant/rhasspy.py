#!/usr/bin/python3
#From "My Raspberry Pi Does Everything!!!" by Anne Brenner 2022

#nodered and homeassistant mqtt are localhost port 1883
#rhasspy mqtt is set to internal mqtt port 12183

import paho.mqtt.client as mqtt
import requests
import datetime
import random
import json
import os
import time

# The callback for when the client receives a CONNACK response from the server.
def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))

    # Subscribing in on_connect() means that if we lose the connection and
    # reconnect then subscriptions will be renewed.
    client.subscribe("hermes/intent/#")

# The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
    print(msg.topic)
    print(str(msg.payload))
    payload = str(msg.payload)
    if "BeamUp" in payload:
        answer="Eye captain. Stand by for beaming."
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
                
    elif "GetTime" in payload:
        now = datetime.datetime.now()
        answer="Current time is " + now.strftime("%I:%M  %p")
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
        print (answer)
        print (r)
                
    elif "GetDate" in payload:
        now = datetime.datetime.now()
        answer="Current date is " + now.strftime("%A %B %d %Y")
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
                
    elif "StarTrek" in payload:
        answers = ["There is no intelligent life on this planet", "Live long and prosper","Today is a good day to die", "To boldly go where no man has gone before", "Highly illogical", "I canna change the laws of physics","Compassion. That's the one thing no machine has ever had. Maybe it's the one thing that keeps men ahead of them", "Live long and prosper"]
        answer=answers[random.randint(1,8)-1]
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
                
    elif "ChangeSwitchState" in payload:
        onvalue='"value": "on"'
        offvalue='"value": "off"'
        if offvalue in payload:
            print("off")
            command='curl "http://192.168.1.129/cm?cmnd=Power%20OFF"' #tasmota IP address
            os.system(command)
            
        elif onvalue in payload:
            print("on")
            command='curl "http://192.168.1.129/cm?cmnd=Power%20ON"' #tasmota IP address
            os.system(command)
                
    elif "TakePicture" in payload:
        print("Take Picture")
        os.system("sudo python take_picture.py")
            
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("localhost", 12183, 60) #this is the rhasspy MQTT server

client.loop_forever()

