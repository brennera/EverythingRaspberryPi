
#!/usr/bin/python
#This is generic everything pi
#192.168.1.177 in fairplay
#192.168.1.125 in denver
#nodered and homeassistant mqtt are localhost port 1883
#rhasspy mqtt is set to internal mqtt port 12183


import paho.mqtt.client as mqtt
import requests
import datetime
import random
import json
import os
import time

address=["https://api.openweathermap.org/data/2.5/weather?q=fairplay,us&APPID=2897dcf612fefd24fda38cfd07dadffc","https://api.openweathermap.org/data/2.5/weather?q=denver,us&APPID=2897dcf612fefd24fda38cfd07dadffc","https://api.openweathermap.org/data/2.5/weather?q=new%20smyrna%20beach,us&APPID=2897dcf612fefd24fda38cfd07dadffc","https://api.openweathermap.org/data/2.5/weather?q=pittsburgh,us&APPID=2897dcf612fefd24fda38cfd07dadffc" ]
location=["fairplay","denver","new smerna beach", "pittsburgh"]

TideAddress=[
"https://api.tidesandcurrents.noaa.gov/api/prod/datagetter?date=today&product=predictions&datum=mllw&interval=hilo&format=json&units=metric&time_zone=lst_ldt&station=8721147","https://api.tidesandcurrents.noaa.gov/api/prod/datagetter?date=today&product=predictions&datum=mllw&interval=hilo&format=json&units=metric&time_zone=lst_ldt&station=8721223"]
TideLocation=["New Smerna Beach","Mosquito Lagoon"]
tides=["","","",""]
types=["","","",""]

def get_weather(addr):
    try:
        url = requests.get(addr)
        text = url.text
        data = json.loads(text)
        print (data)
        temperature=int((data["main"]["temp"] - 273.15)* 1.8 + 32) #F
        tempH=int((data["main"]["temp_max"] - 273.15) * 1.8 + 32) #F
        tempL=int((data["main"]["temp_min"] - 273.15) * 1.8 + 32) #F
        description = data['weather'][0]['description']
        humidity = int(data["main"]["humidity"]) #%
        #pressure = data["main"]["pressure"]/1000*29.52998 #in Hg
        wind_speed = int(data["wind"]["speed"]) #mph
        wind_degree = int(data["wind"]["deg"])
        if wind_degree >= 349 and wind_degree <= 11:
            wind_direction="North"
        elif wind_degree >= 12 and wind_degree <= 33:
            wind_direction="North North East" 
        elif wind_degree >= 34 and wind_degree <= 56:
            wind_direction="Nort hEast"
        elif wind_degree >= 57 and wind_degree <= 78:
            wind_direction="East North East"
        elif wind_degree >= 79 and wind_degree <= 101:
            wind_direction="East"
        elif wind_degree >= 102 and wind_degree <= 123:
            wind_direction="East South East"
        elif wind_degree >= 124 and wind_degree <= 146:
            wind_direction="South East"
        elif wind_degree >= 147 and wind_degree <= 168:
            wind_direction="South South East"
        elif wind_degree >= 169 and wind_degree <= 191:
            wind_direction="South"
        elif wind_degree >= 192 and wind_degree <= 213:
            wind_direction="South South West"
        elif wind_degree >= 214 and wind_degree <= 236:
            wind_direction="South West"
        elif wind_degree >= 237 and wind_degree <= 258:
            wind_direction="West South West"
        elif wind_degree >= 259 and wind_degree <= 281:
            wind_direction="West"
        elif wind_degree >= 282 and wind_degree <= 303:
            wind_direction="West North West"
        elif wind_degree >= 304 and wind_degree <= 326:
            wind_direction="North West"
        else:
            wind_direction="North North West"			
			
        answer=description + ".  temperature" + str(temperature) + "degrees. high" + str(tempH) + "degrees. low" + str(tempL) + "degrees. humidity" + str(humidity) + "percent. wind speed" + str(wind_speed) + " mph from the " + wind_direction
        print (answer)
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
        
    except:
        answer="Couldn't get weather"
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
        
def get_short_weather(x):
    try:
        url = requests.get(address[x])
        text = url.text
        data = json.loads(text)
        print (data)
        temperature=int((data["main"]["temp"] - 273.15)* 1.8 + 32) #F
        tempH=int((data["main"]["temp_max"] - 273.15) * 1.8 + 32) #F
        description = data['weather'][0]['description']
             
        answer=description + " in " + location[x] + ".  temperature " + str(temperature) + " degrees. high " + str(tempH) + " degrees. "
        print (answer)
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
        
    except:
        answer="Couldn't get weather in " + location[x]
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
                
def get_tides(x):
    try:
        url = requests.get(TideAddress[x])
        text = url.text
        data = json.loads(text)
        print (data)
        for i in range(4):
            tides[i]=data["predictions"][i]["t"]
            tides[i]=tides[i][11:]
            types[i]=data["predictions"][i]["type"]
            if types[i]=="L":
                types[i]="low"
            else:
                types[i]="high"
        
            answer=types[i] + " " + tides[i] + " o' clock "
            r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
           
    except:
        answer="Couldn't get tides in " + TideLocation[x]
        r = requests.post("http://localhost:12101/api/text-to-speech",data=answer)
        
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
                
    elif "GetWeather" in payload:
        if "fairplay" in payload:
            get_weather(address[0])
            
        elif "denver" in payload:
            get_weather(address[1])
            
        elif "new smerna beach" in payload:
            get_weather(address[2])
			
        elif "pittsburgh" in payload:
            get_weather(address[3])

        else:
            for i in range(3):
                get_short_weather(i)
                
    elif "GetTides" in payload:
        if "New Smerna Beach" in payload:
            get_tides(0)
        elif "Mosquito Lagoon" in payload:
            get_tides(1)
            
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("localhost", 12183, 60)

client.loop_forever()

