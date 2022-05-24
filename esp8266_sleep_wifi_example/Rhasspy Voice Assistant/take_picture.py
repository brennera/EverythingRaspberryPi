#!/usr/bin/python
#take_picture.py from Node-Red exec node

import datetime
import os

now = datetime.datetime.now()
timestamp=now.strftime('%Y-%m-%d_%H:%M:%S')
print(timestamp)

#command='curl "http://localhost:8765/picture/1/current/" -o "/var/www/html/camera/'+timestamp+'outsidecam.jpg"'
command='curl "http://192.168.1.178:8765/picture/1/current/" -o "/var/www/html/camera/'+timestamp+'outsidecam.jpg"'
os.system(command)

#command='curl "http://localhost:8765/picture/1/current/" -o "/var/www/html/camera/last_outsidecam.jpg"'
command='curl "http://192.168.1.178:8765/picture/1/current/" -o "/var/www/html/camera/last_outsidecam.jpg"'
os.system(command)
