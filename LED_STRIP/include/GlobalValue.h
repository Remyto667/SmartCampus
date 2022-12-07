#include<Arduino.h>
#include <Wire.h> // must be included here so that Arduino library object file references work
#include <RtcDS3231.h>
#include "DHTesp.h" // Click here to get the library: http://librarymanager/All#DHTesp
#include <Ticker.h>
#include "sensirion_common.h"
#include "sgp30.h"          // Only needed for Arduino 1.6.5 and earlier
#include "SSD1306Wire.h"        // legacy: #include "SSD1306.h"
#define countof(a) (sizeof(a) / sizeof(a[0]))

extern RtcDateTime globalDateTime;
extern TempAndHumidity globalTemp;
extern u16 global_tvoc_ppb, global_co2_eq_ppm;
extern char globalDatestring[20];
SSD1306Wire display(0x3c, SDA, SCL);   // ADDRESS, SDA, SCL  -  SDA and SCL usually populate automatically based on your board's pins_arduino.h e.g. https://github.com/esp8266/Arduino/blob/master/variants/nodemcu/pins_arduino.h
extern DHTesp dht;
/** Pin number for DHT11 data pin */
int dhtPin = 16;
RtcDS3231<TwoWire> Rtc(Wire);