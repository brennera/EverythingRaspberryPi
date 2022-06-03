#!/usr/bin/python
#From "My Raspberry Pi Does Everything!!!" by Anne Brenner 2022

import datetime
import os

now = datetime.datetime.now()
timestamp=now.strftime('%Y-%m-%d_%H:%M:%S')
print(timestamp)

command='curl "http://localhost:8765/picture/1/current/" -o "/var/www/html/camera/'+timestamp+'insidecam.jpg"'
os.system(command)

command='curl "http://localhost:8765/picture/1/current/" -o "/var/www/html/camera/last_insidecam.jpg"'
os.system(command)
