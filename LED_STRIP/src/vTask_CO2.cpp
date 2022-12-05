#include "GlobalValue.h"

void vTask3_CO2( void*pvParameters)
{
  UBaseType_t uxPriority;
  uxPriority= uxTaskPriorityGet( NULL);
  for(;;)
  { 
  s16 err=0;
  err = sgp_measure_iaq_blocking_read(&global_tvoc_ppb, &global_co2_eq_ppm);
        if (err == STATUS_OK) {
              Serial.print("CO2eq Concentration:");
              Serial.print(global_co2_eq_ppm);
               Serial.println("ppm");
        } else {
             Serial.println("error reading IAQ values\n"); 
        }
        vTaskDelay( pdMS_TO_TICKS(50) );
	}
  
}
