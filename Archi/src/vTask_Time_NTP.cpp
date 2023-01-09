#include "vTask_Time_NTP.h"
#include <WiFi.h> 
#include "time.h"

char globalDatestring[20];

const char* ntpServer = "pool.ntp.org";
const long gmtOffset_sec = 0;
const int daylightOffset_sec = 3600;
  
bool time_initialized=false;

void init_time()
{
  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);

  time_initialized = true;
}

void printDateTime(const RtcDateTime& dt)
{
    snprintf_P(globalDatestring, 
            countof(globalDatestring),
            PSTR("%02u/%02u/%04u %02u:%02u:%02u"),
            dt.Day(),
            dt.Month(),
            dt.Year(),
            dt.Hour(),
            dt.Minute(),
            dt.Second() );
    Serial.print(globalDatestring);
    Serial.print("");

}


void vTask_Time( void*pvParameters)
{
  if(time_initialized == false)
  {
    init_time();
  }
  UBaseType_t uxPriority;
  uxPriority= uxTaskPriorityGet( NULL);
  for(;;)
  {
    struct tm timeinfo; 
    if(!getLocalTime(&timeinfo))
    {
    Serial.println("Failed to obtain time");
    return; 
    }
    sprintf(globalDatestring, "%D");
    delay(1000);
  }
  
}
