/*
From "My Raspberry Pi Does Everything!!!" by Anne Brenner 2022
*/

#include <ESP8266WiFi.h>
//////////////////////////////////////////////
//Change SSID and PASSWORD to yours
const char* ssid     = "SSID";
const char* password = "PASSWORD";
//////////////////////////////////////////////
String REMOTE="";
WiFiServer server(80);
const int RELAY    =5; //D1 on nodemcu

void connectWifi(const char* ssid, const char* password) {
  int WiFiCounter = 0;
  // We start by connecting to a WiFi network
  Serial.println("Connecting to ");
  Serial.println(ssid);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED && WiFiCounter < 30) {
    delay(1000);
    WiFiCounter++;
    Serial.println(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void setup() {
  pinMode(RELAY, OUTPUT); 
  digitalWrite(RELAY, HIGH);
  delay(2000);
  digitalWrite(RELAY, LOW);
  
  
  Serial.begin(115200);  //Start Serial
  delay(10);
  connectWifi(ssid, password); // Start WiFi
  server.begin();  // Start Server
  
}

void loop() {
  delay(1000);
  int connectFails = 0;

  while ((WiFi.status() != WL_CONNECTED)) {
    connectWifi(ssid, password);
    connectFails++;
    if (connectFails > 4) {
      Serial.println("Failed Connection");
    }
  }

  WiFiClient clientS = server.available();
  if (!clientS) {
    return;
  }
  Serial.println("new client");
  String req = clientS.readStringUntil('\r');
  Serial.println(req);
  clientS.flush();
  if (req.indexOf("?REMOTE=ON") != -1){
    digitalWrite(RELAY, LOW);
    }
  if (req.indexOf("?REMOTE=OFF") != -1) {
    digitalWrite(RELAY, HIGH);
    } 
  if (req.indexOf("?REMOTE=TOGGLE") != -1) {
    digitalWrite(RELAY, !digitalRead(RELAY));
    } 
  clientS.println("HTTP/1.1 200 OK");
  clientS.println("Content-Type: text/html");
  clientS.println(""); //  do not forget this one
  clientS.println("<!DOCTYPE HTML>");
  clientS.println("<html>");
  clientS.println("<form action='' method='get'><fieldset><legend>Relay</legend><input type='radio' name='REMOTE' value='ON' >ON<input type='radio' name='REMOTE' value='OFF' >OFF<input type='radio' name='REMOTE' value='TOGGLE' >TOGGLE<br></fieldset>");
  clientS.println("<input type='submit' value='Submit'></form>");
  clientS.println("</html>");
  delay(10);
  clientS.stop();
}