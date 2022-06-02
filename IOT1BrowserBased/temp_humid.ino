/*
From "My Raspberry Pi Does Everything!!!" by Anne Brenner 2022

D1=SCL green D2=SDA yellow
VCC to 3V
GND to GND
 */
#include <ESP8266WiFi.h>
#include <Adafruit_AHT10.h>

Adafruit_AHT10 aht;

//////////////////////////////////////////////
//Change SSID and PASSWORD to yours
const char* ssid     = "SSID";
const char* password = "PASSWORD";
//Change host to the IP Address of the Everything Raspberry Pi
const char* host = "192.168.1.xxx";
//////////////////////////////////////////////
const char* streamId   = "/current_temperature_get.php";
const int httpPort = 80;

void setup()
{
Serial.begin(115200);
if (! aht.begin()) {
    Serial.println("Could not find AHT10? Check wiring");
    delay(30 * 1000); //wait 30 seconds before trying again
    ESP.restart();
  }
else {Serial.println("AHT10 found");}
}

void loop()
{
  delay(1000);
  sensors_event_t humidity, temp;
  aht.getEvent(&humidity, &temp);// populate temp and humidity objects with fresh data
  Serial.print("Temperature: "); Serial.print(temp.temperature); Serial.println(" degrees C");
  Serial.print("Humidity: "); Serial.print(humidity.relative_humidity); Serial.println("% rH");
  float h = humidity.relative_humidity;
  // Read temperature as Celsius (the default)
  float f = temp.temperature;
  f=f*9/5 + 32;  //convert to Farenheit
  //connect to wifi
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  int WiFiCounter = 0;
  while (WiFi.status() != WL_CONNECTED && WiFiCounter < 20) {
    delay(1000);
    WiFiCounter++;
    Serial.println(".");
  }
  if (WiFi.status() != WL_CONNECTED){
    Serial.println("WiFi not connected");
    delay(30 * 1000); //wait 30 seconds before trying again
  }
  else{Serial.println("WiFi connected");
    //****************upload to Everything Raspberry Pi
    String url =  streamId;
    url += "?temp=";
    url += f;
    url += "&humid=";
    url += h;
    WiFiClient client;
    if (!client.connect(host, httpPort)) {
      Serial.println("connection failed");
    }
    else
      {Serial.println("connection successful");
      Serial.println(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
      client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
      delay(1000);
      client.stop();
    }
  delay(100);
  WiFi.disconnect();
  delay(60 * 1000); // wait a minute before taking new readings
  }
}