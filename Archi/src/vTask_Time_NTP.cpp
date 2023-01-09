#include "vTask_Time_NTP.h"
#include <WiFi.h> 
#include "time.h"

 
char globalNTPDatestring[20];

const char* ntpServer = "pool.ntp.org";
const long gmtOffset_sec = 0;
const int daylightOffset_sec = 3600;
  
bool ntpTime_initialized=false;

void init_NTPTime()
{
  if(WiFi.status() == WL_CONNECTED)
    {
      configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
      ntpTime_initialized = true;
    }
  
}

void printNTPDateTime()
{
    struct tm timeinfo;
    if(!getLocalTime(&timeinfo))
    {
      Serial.println("Failed to obtain time");
      return;
    }
   // Serial.println(&timeinfo, "%A, %B %d %Y %H:%M:%S");
    sprintf(globalNTPDatestring, "%d-0%d-0%d %d:%d:%d \n", timeinfo.tm_year+1900,  timeinfo.tm_mon+1, timeinfo.tm_mday, timeinfo.tm_hour, timeinfo.tm_min, timeinfo.tm_sec);
    Serial.print(globalNTPDatestring);
    Serial.print("");

}


void vTask_Time_NTP( void*pvParameters)
{
  if(ntpTime_initialized == false)
  {
    init_NTPTime();
  }
  for(;;)
  {
  printNTPDateTime();
  vTaskDelay( pdMS_TO_TICKS(1000) );
  }
}

