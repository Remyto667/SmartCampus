#include "vTask_CO2.h"

u16 global_tvoc_ppb, global_co2_eq_ppm;
std::vector< u16 > globals_co2;
bool co2_initialized=false;

void init_CO2()
{
    while (sgp_probe() != STATUS_OK) 
    {
         Serial.println("SGP failed");
         while(1);
    }

  co2_initialized = true;
}

void vTask_CO2( void*pvParameters)
{
  if(co2_initialized == false)
  {
    init_CO2();
  }
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
          globals_co2.push_back(global_co2_eq_ppm);
    } else {
          Serial.println("error reading IAQ values\n"); 
    }
    vTaskDelay( pdMS_TO_TICKS(60000) );
	}
  
}
