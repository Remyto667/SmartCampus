#include "vTask_Time.h"
#include "vTask_Display.h"
#include "vTask_CO2.h"
#include "vTask_Temp.h"

#include<WiFi.h>
//Wifi library
#include"esp_wpa2.h"
//wpa2 library for connections to Enterprise networks
#define EAP_IDENTITY "syou@etudiant.univ-lr.fr"
//if connecting from another corporation, use identity@organisation.domain in Eduroam 
#define EAP_USERNAME "syou@etudiant.univ-lr.fr"
//oftentimes just a repeat of the identity
#define EAP_PASSWORD "sltREf30sltREf30."
//your Eduroam password
const char* ssid = "eduroam";
// Eduroam SSID
const char* host = "arduino.php5.sk";

//external server domain for HTTP connection after authentification
int counter = 0;
// NOTE: For some systems, various certification keys are required to connect to the wifi system.
//       Usually you are provided these by the IT department of your organization when certs are required
//       and you can't connect with just an identity and password.
//       Most eduroam setups we have seen do not require this level of authentication, but you should contact
//       your IT department to verify.
//       You should uncomment these and populate with the contents of the files if this is required for your scenario (See Example 2 and Example 3 below).
//const char *ca_pem = "insert your CA cert from your .pem filehere";
//const char *client_cert = "insert your client cert from your .crt file here";
//const char *client_key = "insert your client key from your .key file here";

/** Task handle for the light value read task */
TaskHandle_t vTask_TimeHandle = NULL;
TaskHandle_t vTask_TempHandle = NULL;
TaskHandle_t vTask_CO2Handle = NULL;
TaskHandle_t vTask_DisplayHandle = NULL; 


void setup()
{
  Serial.begin(9600);
  //while(!Serial);
  Serial.println("Start");

  //xTaskCreate(vTask_Time, "timeTask", 10000, NULL, 1, &vTask_TimeHandle);

  //xTaskCreate(vTask_Temp, "tempTask ", 2048, NULL, 1, &vTask_TempHandle);

  //xTaskCreate(vTask_CO2, "CO2Task", 8196, NULL, 1, &vTask_CO2Handle);

  //xTaskCreate(vTask_Display, "DisplayTask", 8196, NULL, 1, &vTask_DisplayHandle);

  
  delay(10);
  Serial.println();
  Serial.print("Connecting to network: ");
  Serial.println(ssid);
  WiFi.disconnect(true);
  //disconnect form wifi to set new wifi connection
  WiFi.mode(WIFI_STA);
  //init wifi mode
  // Example1 (most common): a cert-file-free eduroam with PEAP (or TTLS)
  WiFi.begin(ssid, WPA2_AUTH_PEAP, EAP_IDENTITY, EAP_USERNAME, EAP_PASSWORD);
  // Example 2: a cert-file WPA2 Enterprise with PEAP
  //WiFi.begin(ssid, WPA2_AUTH_PEAP, EAP_IDENTITY, EAP_USERNAME, EAP_PASSWORD, ca_pem, client_cert, client_key);
  // Example 3: TLS with cert-files and no password//WiFi.begin(ssid, WPA2_AUTH_TLS, EAP_IDENTITY, NULL, NULL, ca_pem, client_cert, client_key);
  while(WiFi.status() != WL_CONNECTED) 
  {
    delay(500);Serial.print(".");counter++;
    if(counter>=60)
    {
      //after 30 seconds timeout -reset board``
      ESP.restart();
      }
      }
      Serial.println("");
      Serial.println("WiFi connected");
      Serial.println("IP address set: "); 
      Serial.println(WiFi.localIP());
      //print LAN IP}
}

/*
void loop () 
{
  Serial.println("scan start");
  // WiFi.scanNetworks will return the number of networks found
  int n= WiFi.scanNetworks();
  Serial.println("scan done");
  if(n== 0) {
    Serial.println("no networks found");
  } 
  else{
    Serial.print(n);
    Serial.println(" networks found");
    for(int i= 0; i< n; ++i) {
      // Print SSID and RSSI for each network found
      Serial.print(i+ 1);
      Serial.print(": ");
      Serial.print(WiFi.SSID(i));
      Serial.print(" (");
      Serial.print(WiFi.RSSI(i));
      Serial.print(")");
      Serial.println((WiFi.encryptionType(i) == WIFI_AUTH_OPEN)?" ":"*");
      delay(10);
    }
  }
  Serial.println("");// Wait a bit before scanning again
  delay(5000);
}

void loop()
{
  WiFiClient client= server.available();
  // listen for incoming clients
  if(client)
  {
    // if you get a client,
    Serial.println("New Client.");
    // print a message out the serial port
    String currentLine = "";
    // make a String to hold incoming data from the client
    while(client.connected())
    {
      // loop while the client's connected
      if(client.available())
      {
        // if there's bytes to read from the client,
        char c = client.read();
        // read a byte, then
        Serial.write(c);
        // print it out the serial monitor
      }
    }
    // close the connection:
    client.stop();
    Serial.println("Client Disconnected.");
  }
}
*/

  void loop()
  {
    if(WiFi.status() == WL_CONNECTED) 
    {
      //if we are connected to Eduroam network
      counter = 0;
      //reset counter
      Serial.println("Wifi is still connected with IP: ");
       Serial.println(WiFi.localIP());
       //inform user about his IP address
       
    }
    else if(WiFi.status() != WL_CONNECTED) 
    {
      //if we lost connection, retry
      WiFi.begin(ssid);    
    }
    while(WiFi.status() != WL_CONNECTED)
    {
      //during lost connection, print dots
      delay(500);
      Serial.print(".");
      counter++;
      if(counter>=60)
      {
        //30 seconds timeout -reset board
        ESP.restart();
      }
    }
    Serial.print("Connecting to website: ");
    Serial.println(host);
    WiFiClient client;
    if(client.connect(host, 80))
    {
      String url = "/rele/rele1.txt";
      client.print(String("GET ") + url + " HTTP/1.1\r\n"+ "Host: "+ host + "\r\n"+ "User-Agent: ESP32\r\n"+ "Connection: close\r\n\r\n");
      while(client.connected())
      {
        String line = client.readStringUntil('\n');
        if(line == "\r") 
        {
          break;
        }
      }
      String line = client.readStringUntil('\n');
      Serial.println(line);
    }
    else
    {
      Serial.println("Connection unsucessful");
    } 
  }
