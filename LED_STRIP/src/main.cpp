#include "vTask_Time.h"
#include "vTask_Display.h"
#include "vTask_CO2.h"
#include "vTask_Temp.h"



void triggerGetTemp();

/** Task handle for the light value read task */
TaskHandle_t vTask1_TimeHandle = NULL;
TaskHandle_t vTask2_TempHandle = NULL;
TaskHandle_t vTask3_CO2Handle = NULL;
TaskHandle_t vTask4_DisplayHandle = NULL; 


void setup()
{
  Serial.begin(9600);
  while(!Serial);
  Serial.println("Start");

  display.init();

  display.flipScreenVertically();
  display.setFont(ArialMT_Plain_10);

  Rtc.Begin();
  RtcDateTime compiled = RtcDateTime(__DATE__, __TIME__);
  Rtc.SetDateTime(compiled);
  xTaskCreate(vTask1_Time, "timeTask", 10000, NULL, 1, &vTask1_TimeHandle);

  dht.setup(dhtPin, DHTesp::DHT22);
	xTaskCreate(vTask2_Temp, "tempTask ", 2048, NULL, 1, &vTask2_TempHandle);

  while (sgp_probe() != STATUS_OK) {
         Serial.println("SGP failed");
         while(1);}
  xTaskCreate(vTask3_CO2, "CO2Task", 8196, NULL, 1, &vTask3_CO2Handle);

  xTaskCreate(vTask4_Display, "DisplayTask", 8196, NULL, 1, NULL);
}

void loop () 
{
}
