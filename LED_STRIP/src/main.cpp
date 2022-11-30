#include <Arduino.h>

void MaTache( void*pvParameters)// <-une tâche
{
  
  int variable1;// <-variable allouée dans la pile (*stack*) de la tâche et unique pour chaque instance de tâche
  static int variable2;// <-variable allouée en dehors de la pile de la tâche et partagée pour chaque instance de tâche
  for( ;; )// <-boucle infinie
  {
    Serial.printf("MaTache\n");
    delay(2000);
  }
}
void setup()
{
  Serial.begin(9600);
  while(!Serial);
  Serial.println("Start");
  
  xTaskCreate(
    MaTache,/* Task function. */
    "MaTache",/* name of task. */
    1000,/* Stack size of task */
    NULL,/* parameter of the task */
    1,/* priority of the task */
    NULL);/* Task handle to keep track of created task */
}
void loop()
{
  Serial.printf("LaTacheDuLoop()\n");
  delay(1000); 
}