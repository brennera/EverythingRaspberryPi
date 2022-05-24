/*
 * Node MCU:
 * On no WiFi: 17.6 mA
 * WiFi:73.5 (max 82.7)mA
 * Sleep:1.45mA
 * 
 * Wemos D1 mini:
 * On no WiFI: 16.2mA
 * WiFi: 72mA
 * Sleep: .35mA
 * 
 * Wemos D1 mini V3:
 * On no WiFi: 15mA
 * Wifi: 71.5mA
 * Sleep: 0.1to 0.2mA Reported as .15mA same as for mini pro:
 * https://salvatorelab.com/2021/03/wemos-d1-mini-power-consumption-on-deep-sleep/
 * 
 * ESP8266-01:
 * On no WiFI: 16.2mA
 * WiFi: 72mA
 * Sleep: .45mA
 */
#include <ESP8266WiFi.h>
const char* ssid     = "ANNEDVR";
const char* password = "1765queensview";
//const char* ssid     = "ANNE_SPECTRUM";
//const char* password = "YE2-5192";

/*
 * IPAddress staticIP(192,168,1,22);
   IPAddress gateway(192,168,1,1);
   IPAddress subnet(255,255,255,0);
 */

const char* host = "brennercaprera.ddns.net";

const char* streamId   = "/raspberrypi/sample.php";
// the setup function runs once when you press reset or power the board
void setup() {
  
  WiFi.mode( WIFI_OFF );
  WiFi.forceSleepBegin();
  delay( 1 );
//Do stuff that does not need wifi Requires about 20 mA
  
  // initialize digital pin 13 as an output.
  Serial.begin(115200);
  Serial.println("");
  Serial.println("Hello World");
  delay(1000);
  Serial.println("Hello World");
  delay(1000);
  Serial.println("Hello World");
  delay(1000);
  Serial.println("Hello World");
  delay(1000);
  Serial.println("Hello World");
  delay(1000);

  //turn on wifi requires about 70-80 mA
  WiFi.forceSleepWake();
delay( 1 );
  // Disable the WiFi persistence.  The ESP8266 will not load and save WiFi settings in the flash memory.
  WiFi.persistent( false );
  WiFi.mode(WIFI_STA);
  
  /*
   *  WiFi.config(staticIP, gateway, subnet);
   */
   WiFi.begin(ssid, password);
  int WiFiCounter = 0;
  while (WiFi.status() != WL_CONNECTED && WiFiCounter < 10) {
    delay(1000);
    WiFiCounter++;
    Serial.println(".");
  }
  if (WiFi.status() != WL_CONNECTED){Serial.println("WiFi not connected");}
  else{Serial.println("WiFi connected");
  /*  WiFiClient client;
    const int httpPort = 80;
    if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    }
    else
    {Serial.println("connection successful");
    String url =  streamId;
    url += "?temp=";
    url += "hello";
    Serial.println(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
   unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println(">>> Client Timeout !");
      client.stop();}}
      
    
    }*/
  }
  
  
  delay(5000);
  
  WiFi.disconnect();
  Serial.println("Going to Sleep");
  delay(1000);

  //Deep Sleep requires about 0.3 mA
  // WAKE_RF_DISABLED to keep the WiFi radio disabled when we wake up
  ESP.deepSleep( 10 * 1000000, WAKE_RF_DISABLED );
  //note after waking up from sleep esp uses ~10Mamp
  //correct with below
  //ESP.deepSleep( 0, WAKE_RF_DISABLED );//indefinite sleep
  
  //ESP.deepSleep(10 * 1000000, WAKE_RF_DEFAULT);
  delay(100); // wait for deep sleep to happen
}

// the loop function runs over and over again forever
void loop() {

}
