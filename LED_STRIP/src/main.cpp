#include "GlobalValue.h"
/**************************************************************/
/* Example how to read DHT sensors from an ESP32 using multi- */
/* tasking.                                                   */
/* This example depends on the Ticker library to wake up      */
/* the task every 20 seconds                                  */
/**************************************************************/



void triggerGetTemp();

/** Task handle for the light value read task */
TaskHandle_t vTask2_TempHandle = NULL;
TaskHandle_t vTask1_TimeHandle = NULL;
TaskHandle_t vTask3_CO2Handle = NULL;


RtcDS3231<TwoWire> Rtc(Wire);

SSD1306Wire display(0x3c, SDA, SCL);   // ADDRESS, SDA, SCL  -  SDA and SCL usually populate automatically based on your board's pins_arduino.h e.g. https://github.com/esp8266/Arduino/blob/master/variants/nodemcu/pins_arduino.h

RtcDateTime globalDateTime;
TempAndHumidity globalTemp;
u16 global_tvoc_ppb, global_co2_eq_ppm;
char globalDatestring[20];
/* for normal hardware wire use above */
//TaskHandle_t xTask2Handle= NULL;

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


void vTask4_Display(void* pvParameters)
{
  UBaseType_t uxPriority;
  uxPriority= uxTaskPriorityGet( NULL);
  // clear the display
  for(;;)
  {
    display.clear();

    display.setFont(ArialMT_Plain_10);
    display.setTextAlignment(TEXT_ALIGN_RIGHT);

    display.drawString(50, 50, String(global_co2_eq_ppm)+"ppm");
    display.drawString(70, 10, globalDatestring);
    display.drawString(50, 30, " T:" + String(globalTemp.temperature, 0) + " H:" + String(globalTemp.humidity, 0));
    // write the buffer to the display
    display.display();

    vTaskDelay( pdMS_TO_TICKS( 1000) );
  }
}

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
