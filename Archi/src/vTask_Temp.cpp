#include "vTask_Temp.h"

TempAndHumidity globalTemp;
std::vector< TempAndHumidity > *globalTemps;
std::vector< TempAndHumidity > *globalHums;

DHTesp dht;
/** Pin number for DHT11 data pin */
int dhtPin = 16;
bool temp_initialized=false;

void init_temp()
{
  dht.setup(dhtPin, DHTesp::DHT22);

  temp_initialized = true;
}

bool printTemperature(const TempAndHumidity& tempVal) {
	
  Serial.println(" T:" + String(tempVal.temperature) + " H:" + String(tempVal.humidity));
	Serial.println("");
  return true;
}

void vTask_Temp( void*pvParameters)
{
  if(temp_initialized == false)
  {
    init_temp();
  }
  UBaseType_t uxPriority;
  uxPriority= uxTaskPriorityGet( NULL);
  for(;;)
  {
    globalTemp = dht.getTempAndHumidity();
    globalTemps->push_back(globalTemp);
    printTemperature(globalTemp);

    vTaskDelay( pdMS_TO_TICKS(1000) );
	}
}