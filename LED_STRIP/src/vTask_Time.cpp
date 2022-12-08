#include "vTask_Time.h"

RtcDateTime globalDateTime;
char globalDatestring[20];
RtcDS3231<TwoWire> Rtc(Wire);
bool time_initialized=false;

void init_time()
{
  Rtc.Begin();
  RtcDateTime compiled = RtcDateTime(__DATE__, __TIME__);
  Rtc.SetDateTime(compiled);

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
    globalDateTime = Rtc.GetDateTime();
    printDateTime(globalDateTime);
    vTaskDelay( pdMS_TO_TICKS(50) );
  }
  
}
