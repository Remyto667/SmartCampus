#include "vTask_Time_NTP.h"
#include <WiFi.h> 
#include "time.h"

 
String globalNTPDatestring;

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
   String sec, hour, min ;

   if(timeinfo.tm_sec<10)
   {
    sec = "0"+String(timeinfo.tm_sec);
   }
   else
   {
    sec = String(timeinfo.tm_sec);
   }

   if(timeinfo.tm_min<10)
   { min = "0"+String(timeinfo.tm_min); }
   else
   { min = String(timeinfo.tm_min); }

   if(timeinfo.tm_isdst == 0)
    {
      hour = String(timeinfo.tm_hour + 1);
    }
    else{
      hour = String(timeinfo.tm_hour);
    }

   if(timeinfo.tm_hour < 10)
   {
    hour = "0"+String(hour);
   }
   else
   {
    hour = String(hour);
   }

   
    globalNTPDatestring = ""+ String(timeinfo.tm_year+1900) + "-0" + String(timeinfo.tm_mon+1)+"-0"+String(timeinfo.tm_mday)+" "+ hour +":"+min+":"+sec;
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

