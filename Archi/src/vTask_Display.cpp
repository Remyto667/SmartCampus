#include "vTask_Display.h"

SSD1306Wire display(0x3c, SDA, SCL);
bool display_initialized=false;

void init_diplay()
{
  display.init();

  display.flipScreenVertically();
  display.setFont(ArialMT_Plain_10);

  display_initialized = true;
}

void vTask_Display(void* pvParameters)
{
  if(display_initialized == false)
  {
    init_diplay();
  }
  UBaseType_t uxPriority;
  uxPriority= uxTaskPriorityGet( NULL);
  // clear the display
  for(;;)
  {
    display.clear();

    display.setFont(ArialMT_Plain_10);
    display.setTextAlignment(TEXT_ALIGN_RIGHT);

    display.drawString(100, 10, globalNTPDatestring);
    display.drawString(50, 30, " T:" + String(globalTemp, 0) + " H:" + String(globalHum, 0));
    display.drawString(50, 50, String(global_co2_eq_ppm)+"ppm");
    // write the buffer to the display
    display.display();

    vTaskDelay( pdMS_TO_TICKS( 1000) );
  }
}