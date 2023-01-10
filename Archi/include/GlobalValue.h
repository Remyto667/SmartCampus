#include <Arduino.h>
#include <Wire.h> // must be included here so that Arduino library object file references work
#include <RtcDS3231.h>
#include "DHTesp.h" // Click here to get the library: http://librarymanager/All#DHTesp
#include <Ticker.h>
#include "sensirion_common.h"
#include "sgp30.h"          // Only needed for Arduino 1.6.5 and earlier
#include "SSD1306Wire.h"        // legacy: #include "SSD1306.h"
#include <vector>


extern RtcDateTime globalDateTime;
extern float globalTemp;
extern float globalHum;
extern u16 global_tvoc_ppb, global_co2_eq_ppm;
//extern char globalDatestring[20];
extern String globalNTPDatestring;

extern std::vector< float > globalTemps;
extern std::vector< float > globalHums;
extern std::vector< u16 > globals_co2;