#include "GlobalValue.h"



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


void vTask1_Time( void*pvParameters)
{
  UBaseType_t uxPriority;
  uxPriority= uxTaskPriorityGet( NULL);
  for(;;)
  {
    globalDateTime = Rtc.GetDateTime();
    printDateTime(globalDateTime);
    vTaskDelay( pdMS_TO_TICKS(50) );
  }
  
}
