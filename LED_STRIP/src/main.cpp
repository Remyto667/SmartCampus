#include "vTask_Time.h"
#include "vTask_Display.h"
#include "vTask_CO2.h"
#include "vTask_Temp.h"


/** Task handle for the light value read task */
TaskHandle_t vTask_TimeHandle = NULL;
TaskHandle_t vTask_TempHandle = NULL;
TaskHandle_t vTask_CO2Handle = NULL;
TaskHandle_t vTask_DisplayHandle = NULL; 


void setup()
{
  Serial.begin(9600);
  while(!Serial);
  Serial.println("Start");

  xTaskCreate(vTask_Time, "timeTask", 10000, NULL, 1, &vTask_TimeHandle);

	xTaskCreate(vTask_Temp, "tempTask ", 2048, NULL, 1, &vTask_TempHandle);

  xTaskCreate(vTask_CO2, "CO2Task", 8196, NULL, 1, &vTask_CO2Handle);

  xTaskCreate(vTask_Display, "DisplayTask", 8196, NULL, 1, &vTask_DisplayHandle);
}

void loop () 
{
}
