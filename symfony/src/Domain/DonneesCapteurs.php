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
            if(sizeof(json_decode($response->getContent())) > 0)
            {
                // rajouter maj de alert dans room
                $this->donneesPourSalle[$type] = json_decode($response->getContent())[0];
            }
            else{
                $this->donneesPourSalle[$type] = (object) array('valeur' => 'NULL', 'dateCapture' => 'NULL');
            }
        }

        return $this->donneesPourSalle ;
    }
}