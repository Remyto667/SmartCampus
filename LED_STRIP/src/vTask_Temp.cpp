#include "GlobalValue.h"

DHTesp dht;
/** Pin number for DHT11 data pin */
int dhtPin = 16;

bool printTemperature(const TempAndHumidity& tempVal) {
	
  Serial.println(" T:" + String(tempVal.temperature) + " H:" + String(tempVal.humidity));
	Serial.println("");
  return true;
}

void vTask2_Temp( void*pvParameters)
{
  UBaseType_t uxPriority;
  uxPriority= uxTaskPriorityGet( NULL);
  for(;;)
  {
    globalTemp = dht.getTempAndHumidity();
    printTemperature(globalTemp);
    vTaskDelay( pdMS_TO_TICKS(50) );
	}
  
}