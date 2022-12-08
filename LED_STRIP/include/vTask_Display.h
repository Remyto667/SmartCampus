#ifndef __vTask_Display_H__
#define __vTask_Display_H__
#include "GlobalValue.h"

extern SSD1306Wire display;   // ADDRESS, SDA, SCL  -  SDA and SCL usually populate automatically based on your board's pins_arduino.h e.g. https://github.com/esp8266/Arduino/blob/master/variants/nodemcu/pins_arduino.h

void vTask_Display( void*pvParameters);
void init_diplay();
#endif /* !__vTask_Display_H__ */