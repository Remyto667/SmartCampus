#include "GlobalValue.h"



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