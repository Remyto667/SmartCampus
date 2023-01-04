<?php

namespace App\Domain;

use App\Entity\Room;
use Symfony\Component\HttpClient\HttpClient;

class DonneesCapteurs
{
    private $donneesPourSalle ;

    public function __construct()
    {
        $this->donneesPourSalle = array();
    }

    public function getDonneesPourSalle(int $tag):array
    {
        $types["T"] = "temp";
        $types["H"] = "hum";
        $types["C"] = "co2";

        $client = HttpClient::create();
        foreach($types as $type => $nom)
        {
            $response = $client->request('GET', 'http://sae34.k8s.iut-larochelle.fr/api/captures?nom='.$nom.'&tag='.$tag.'&page=1', [
            'headers' => [
                'Accept' => 'application/ld+json',
                'dbname' => 'sae34bdx1eq3',
                'username' => 'x1eq3',
                'userpass' => 'bRepOh4UkiaM9c7R'
                ],
            ]);
            $this->donneesPourSalle[$type] = json_decode($response->getContent())[0];
        }
        /*
        $jsonT = "../assets/json/".$room->getName()."-temp.json";
        $jsonH = "../assets/json/".$room->getName()."-hum.json";
        $jsonC = "../assets/json/".$room->getName()."-co2.json";
        $fileT = file_get_contents($jsonT);
        $fileH = file_get_contents($jsonH);
        $fileC = file_get_contents($jsonC);
        $objT = json_decode($fileT);
        $objH = json_decode($fileH);
        $objC = json_decode($fileC);
*/
        return $this->donneesPourSalle ;
    }
}