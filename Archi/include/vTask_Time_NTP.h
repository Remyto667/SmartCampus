#ifndef __vTask_Time_NTP_H__
#define __vTask_Time_NTP_H__
#include "GlobalValue.h"


extern const char* ntpServer;
extern const long gmtOffset_sec;
extern const int daylightOffset_sec;

void vTask_Time_NTP( void*pvParameters);
void printNTPDateTime();
void init_NTPTime();

#endif /* !__vTask_Time_NTP_H__ */