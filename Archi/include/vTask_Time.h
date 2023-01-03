#ifndef __vTask_Time_H__
#define __vTask_Time_H__
#include "GlobalValue.h"

extern RtcDS3231<TwoWire> Rtc;
#define countof(a) (sizeof(a) / sizeof(a[0]))

void vTask_Time( void*pvParameters);
void printDateTime(const RtcDateTime& dt);
void init_time();
#endif /* !__vTask_Time_H__ */