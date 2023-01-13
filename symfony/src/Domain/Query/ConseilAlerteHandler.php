<?php

namespace App\Domain\Query;

use App\Repository\ConseilRepository;
use App\Domain\DonneesCapteurs;
use Doctrine\Persistence\ManagerRegistry;

class ConseilAlerteHandler
{
    private $donneesCapteurs;

    public function __construct(DonneesCapteurs $donneesCapteurs)
    {
        $this->donneesCapteurs = $donneesCapteurs;
    }

    public function getWeatherData()
    {
        $url = 'https://api.openweathermap.org/data/2.5/weather?q=La%20Rochelle&appid=3e754b09e95d904997b1f4c2a5597bc5';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $weatherData = json_decode($response, true);

        if (!array_key_exists('main', $weatherData)) {
            return false ;
        }

        $temp_outside = $weatherData['main']['temp'];

        return $temp_outside - 273.15;
    }

    public function typeOfAlert($data, $requete, $temp_outside)
    {
        //récupératoin des valeurs
        $temp = $data["T"]->valeur;
        $hum = $data["H"]->valeur;
        $co2 = $data["C"]->valeur;
        //récupération du type des salles
        $roomType = $requete->getRoom()->getType();
        //Valeurs pour le type de conseils
        $temp_alerte_sup = false;
        $temp_alerte_inf = false;
        $hum_alerte_sup = false;
        $hum_alerte_inf = false;
        $co2_alerte_sup = false;
        $co2_alerte_inf = false;
        $temp_sup_outside = false;
        $no_data = false;



        /*
        // Création de l'instance HttpClient
        $client = HttpClient::create();

        // Envoi de la requête à l'API OpenWeather
        $response = $client->request('GET',https://api.openweathermap.org/data/2.5/weather?q=London&appid=3e754b09e95d904997b1f4c2a5597bc5);

        // Récupérez la réponse sous forme de tableau PHP
        $data = json_decode($response->getBody(), true);

        // Récupérez la température à partir du tableau de données
        $temperature = $data['main']['temp'];
        */

        if ($temp > $roomType->getTempMax()) {
            $temp_alerte_sup = true;
        }
        if ($temp < $roomType->getTempMin()) {
            $temp_alerte_inf = true;
        }
        if ($hum > $roomType->getHumMax()) {
            $hum_alerte_sup = true;
        }
        if ($hum < $roomType->getHumMin()) {
            $hum_alerte_inf = true;
        }
        if ($co2 >= $roomType->getCo2Max()) {
            $co2_alerte_sup = true;
        }
        if ($co2 < $roomType->getCo2Min()) {
            $co2_alerte_inf = true;
        }
        if ($temp_outside > $temp) {
            $temp_sup_outside = true;
        }
        if ($temp == 0 or $hum == 0 or $co2 == 0) {
            $no_data = true;
        }

        //appel du repository et renvoie du conseil
        return $requete->getAdvice($temp_alerte_sup, $temp_alerte_inf, $hum_alerte_sup, $hum_alerte_inf, $co2_alerte_sup, $co2_alerte_inf, $temp_sup_outside, $no_data);
    }

    public function handle(ConseilAlerteQuery $requete)
    {
        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());


        //récupération des données de température de la rochelle
        $temp_outside = $this->getWeatherData();
        //renvoie le conseil
        return $this->typeOfAlert($data, $requete, $temp_outside);
    }

}