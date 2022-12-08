#ifndef __vTask_Temp_H__
#define __vTask_Temp_H__
#include "GlobalValue.h"

extern DHTesp dht;
/** Pin number for DHT11 data pin */
extern int dhtPin;

void vTask_Temp( void*pvParameters);
bool printTemperature(const TempAndHumidity& tempVal);
void triggerGetTemp();
void init_temp();

#endif /* !__vTask_Temp_H__ */