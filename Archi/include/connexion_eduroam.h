#include <WiFi.h> //Wifi library

#include"esp_wpa2.h" //wpa2 library for connections to Enterprise networks


#define EAP_IDENTITY "syou@etudiant.univ-lr.fr" //if connecting from another corporation, use identity@organisation.domain in Eduroam 
#define EAP_USERNAME "syou@etudiant.univ-lr.fr"//oftentimes just a repeat of the identity
#define EAP_PASSWORD "sltREf30sltREf30."//your Eduroam password
const char* ssid = "eduroam";// Eduroam SSID


