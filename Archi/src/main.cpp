#include "vTask_Time.h"
#include "vTask_Display.h"
#include "vTask_CO2.h"
#include "vTask_Temp.h"
#include "vTask_Post.h"
#include "connexion_eduroam.h"
#include "connexion_tel.h"

// Task handle for the light value read task 
TaskHandle_t vTask_TimeHandle = NULL;
TaskHandle_t vTask_TempHandle = NULL;
TaskHandle_t vTask_CO2Handle = NULL;
TaskHandle_t vTask_DisplayHandle = NULL; 

int counter = 0;

void setup()
{
  Serial.begin(9600);
  //while(!Serial);
  Serial.println("Start");

  WiFi.disconnect(true);
  //disconnect form wifi to set new wifi connection
  WiFi.mode(WIFI_STA);
  //init wifi mode
  // Example1 (most common): a cert-file-free eduroam with PEAP (or TTLS)
  WiFi.begin(ssid, WPA2_AUTH_PEAP, EAP_IDENTITY, EAP_USERNAME, EAP_PASSWORD);

  //Serial.println(telSsid);
  //Serial.println(password);

  //WiFi.begin(telSsid, password);    
  

  // Example 2: a cert-file WPA2 Enterprise with PEAP
  //WiFi.begin(ssid, WPA2_AUTH_PEAP, EAP_IDENTITY, EAP_USERNAME, EAP_PASSWORD, ca_pem, client_cert, client_key);
  // Example 3: TLS with cert-files and no password//WiFi.begin(ssid, WPA2_AUTH_TLS, EAP_IDENTITY, NULL, NULL, ca_pem, client_cert, client_key);
  while(WiFi.status() != WL_CONNECTED) 
  {
    delay(500);Serial.print(".");
    counter++;
    if(counter>=60)
    {//connexion à un telephone
    }
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address set: "); 
  Serial.println(WiFi.localIP());
  //print LAN IP}


  xTaskCreate(vTask_Time, "timeTask", 10000, NULL, 1, &vTask_TimeHandle);

  xTaskCreate(vTask_Temp, "tempTask ", 2048, NULL, 1, &vTask_TempHandle);

  xTaskCreate(vTask_CO2, "CO2Task", 8196, NULL, 1, &vTask_CO2Handle);

  xTaskCreate(vTask_Display, "DisplayTask", 8196, NULL, 1, &vTask_DisplayHandle);

  xTaskCreate(vTask_Post, "PostTask", 8196, NULL, 1, NULL);

}

void loop() 
{

}