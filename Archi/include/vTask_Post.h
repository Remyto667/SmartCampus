#include "GlobalValue.h"
#include <WiFi.h>
#include <HTTPClient.h>

void vTask_Post( void*pvParameters);
float avarageTempValue(std::vector< float > vec);
float avarageHumValue(std::vector< float > vec);
int avarageCo2Value(std::vector< u16 > vec);

extern const char* serverName; 

extern unsigned long lastTime;
extern unsigned long timerDelay;

