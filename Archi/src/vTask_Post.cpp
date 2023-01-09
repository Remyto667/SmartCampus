#include "vTask_Post.h"

const char* serverName = "http://sae34.k8s.iut-larochelle.fr/api/captures"; 

unsigned long lastTime = 0;
unsigned long timerDelay = 900000;

void vTask_Post( void*pvParameters)
{
    delay(timerDelay);
    for(;;)
    {
        if((millis() -lastTime) > timerDelay) 
        {
            //Check WiFi connection status
            if(WiFi.status()== WL_CONNECTED)
            {
                WiFiClient client;
                HTTPClient http;
                // Your Domain name with URL path or IP address with path
                http.begin(client, serverName);

                // If you need an HTTP request with a content type: application/json, use the following:
                http.addHeader("Content-Type", "application/ld+json");
                http.addHeader("accept", "application/ld+json");
                http.addHeader("dbname", "sae34bdx1eq3");
                http.addHeader("username", "x1eq3");
                http.addHeader("userpass", "bRepOh4UkiaM9c7R");

                //int i = http.POST("{\"nom\":\"temp\",\"valeur\":\"20.4\",\"dateCapture\":\"2023-01-09 15:12:35\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
                if(globalTemp.temperature != NAN)
                {
                    int i = http.POST("{\"nom\":\"temp\",\"valeur\":\"" + String(globalTemp.temperature, 1) + "\",\"dateCapture\":\"" + String(globalNTPDatestring) + "\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
                }
                if(globalTemp.humidity != NAN)
                {       
                    http.POST("{\"nom\":\"hum\",\"valeur\":\""+ String(globalTemp.humidity, 1) +"\",\"dateCapture\":\"" + String(globalNTPDatestring) +"\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
                }
                if(global_co2_eq_ppm != 0)
                {
                    http.POST("{\"nom\":\"co2\",\"valeur\":\""+ String(global_co2_eq_ppm) +"\",\"dateCapture\":\"" + String(globalNTPDatestring) +"\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
                }
                http.end();
            }
            else
            {
                Serial.println("WiFi Disconnected");
            }
            lastTime = millis();
        }
    }
}
