
extern "C" {
#include "user_interface.h"
}
#include <ESP8266WiFi.h>

#include <Wire.h>
#include <Adafruit_Sensor.h>

#include <ESP8266HTTPClient.h>




#include "DHT.h"
#define DHTPIN 2 //this is  D4 on  wemos d1 mini

//#define DHTTYPE DHT22   // DHT 22  (AM2302), AM2321
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

//***********Change this
#define debugln(a) (Serial.println(a))//print comments
//#define debug(a) (Serial.print(a))

#define debugln(a) //use this for no printing
#define debug(a)
//*******************************

//Sleep nodemcu (larger) devkit ch340G 0.9 is 1 ma
//Sleep nodemcu V3 ch340G 1.0 is 2.4 ma
//sleep nodemcu (smaller) is 10 ma HiLetgo
//sleep wemos d1 mini cd340G is 0.6 ma
const char* ssid     = "ANNE_VAN";
//const char* ssid     = "ANNENET";
const char* password = "evergreen";

IPAddress staticIP(192,168,53,21);
IPAddress gateway(192,168,53,1);
IPAddress subnet(255,255,255,0);

const char* host2 = "192.168.53.1";
//const char* host2 = "192.168.1.110";
//const char* host2 = "brennercaprera.ddns.net";
const char* streamId2   = "/current_temperature_get.php";
//const char* streamId2   = "/raspberrypi/CurrentTempGET.php";
const int httpPort = 80;
//const int httpPort = 4572;

float humidity;

void setup()
{
 
  //The chip won’t turn on RF after waking up from Deep-sleep. 
  //Power consumption is the lowest, same as in Modem-sleep
 // system_deep_sleep_set_option(3);
Serial.begin(115200);

bool status;
delay(2000);
dht.begin();
delay(2000);

}


void loop()
{
   WiFi.disconnect();
  delay(2000);

 humidity = dht.readHumidity();
  // Read temperature as Celsius (the default)
float t = dht.readTemperature();
  // Read temperature as Fahrenheit (isFahrenheit = true)
float f = dht.readTemperature(true);

  debug(f);
  debug("*");
  debug(humidity);
  debugln(" %");

  //delay(30000); //30 seconds
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  WiFi.config(staticIP, gateway, subnet);
  int WiFiCounter = 0;
  while (WiFi.status() != WL_CONNECTED && WiFiCounter < 20) {
    delay(500);
    WiFiCounter++;
    debugln(WiFiCounter);
    //debugln(".");
  }
  //*************** block out for testing
  if (WiFi.status() != WL_CONNECTED){
  debugln("WiFi not connected");
  delay(1000);
 /* debugln("Time to sleep");
   ESP.deepSleep(10e6); // 10e6 is 10 microseconds
   delay(1000); // a short delay to keep in loop while Deep Sleep is being implemented.
 */
  }
  else{debugln("WiFi connected");
    debug("IP address:\t");
  debugln(WiFi.localIP());
 // }
  
  

String url =  streamId2;
    url += "?temp=";
    url += f;
    url += "&humid=";
    url += humidity;
    url +="&gas_level=0";
    
    url +="&pressure=0";
   
    url +="&altitude=0";
    
   


   WiFiClient client2;
  
  if (!client2.connect(host2, httpPort)) {
    debugln("connection failed");
    }
  else
    {debugln("connection successful");
    
    debugln(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host2 + "\r\n" + 
               "Connection: close\r\n\r\n");
    client2.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host2 + "\r\n" + 
               "Connection: close\r\n\r\n");
    delay(10);
    client2.stop();
    }

  delay(10);
  }//when no sleep
  //****************************************
  delay(2000);
  WiFi.disconnect();
  delay(60000);//60 seconds


/*  delay(500);
  
  debugln("Time to sleep");

 // ESP.deepSleep(10e6); // 10e6 is 10 seconds
  //ESP.deepSleep(10e6*12); // 2 minutes
  ESP.deepSleep(60e6); //60 seconds of sleep
  //ESP.deepSleep(30e6*3); //90 seconds of sleep
  delay(500); // a short delay to keep in loop while Deep Sleep is being implemented.
  */
}
