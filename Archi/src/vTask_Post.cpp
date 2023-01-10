#include "vTask_Post.h"

const char* serverName = "http://sae34.k8s.iut-larochelle.fr/api/captures"; 

unsigned long lastTime = 0;
unsigned long timerDelay = 900000;

float avarageTempValue(std::vector< float > vec)
{
    float sum = 0;
    float avg = 0;
    int size = 0;
    for (auto& i : vec)
    {
        if(i == NAN)
        {
            return NAN;
        }
        else if(i > -40 && i < 80)
        {
           sum += i; 
        }
        else{
            sum += 0 ;
        }
        size++;
        //Serial.println(i);
    }
    //Serial.println(size);
    //Serial.println(sum);
    avg = sum / size;
    //Serial.println(avg);
    return avg;
}

float avarageHumValue(std::vector< float > vec)
{
    float sum = 0;
    float avg = 0;
    for (auto& i : vec)
    {
        if(i == NAN)
        {
            return NAN;
        }
        else if(i > 5 && i < 99)
        {
           sum += i; 
        }
        //Serial.println(i);
    }
    //Serial.println(size);
    //Serial.println(sum);
    avg = sum / vec.size();
    //Serial.println(avg);
    return avg;
}

int avarageCo2Value(std::vector< u16 > vec)
{
    int sum = 0;
    int avg = 0;
    for (auto& i : vec)
    {
        if(i >= 400)
        {
            sum += i;
        }
        else
        {
            return 0; 
        }
        Serial.println(i);
    }
    //Serial.println(size);
    Serial.println(sum);
    avg = sum / vec.size();
    Serial.println(avg);
    return avg;
}

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

                float temp = avarageTempValue(globalTemps);
                float hum = avarageHumValue(globalHums);
                int co2 = avarageCo2Value(globals_co2);
                globalTemps.clear();
                globalHums.clear();
                globals_co2.clear();
                
                //int i = http.POST("{\"nom\":\"temp\",\"valeur\":\"20.4\",\"dateCapture\":\"2023-01-09 15:12:35\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
                if(temp != NAN)
                {
                    int i = http.POST("{\"nom\":\"temp\",\"valeur\":\"" + String(temp, 1) + "\",\"dateCapture\":\"" + String(globalNTPDatestring) + "\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
                }
                if(hum != NAN)
                {       
                    http.POST("{\"nom\":\"hum\",\"valeur\":\""+ String(hum, 1) +"\",\"dateCapture\":\"" + String(globalNTPDatestring) +"\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
                }
                if(global_co2_eq_ppm != 0)
                {
                    http.POST("{\"nom\":\"co2\",\"valeur\":\""+ String(co2) +"\",\"dateCapture\":\"" + String(globalNTPDatestring) +"\",\"localisation\":\"D207\",\"description\":\"test\",\"tag\":3}");
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
