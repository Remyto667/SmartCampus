<?php

namespace App\Domain;

use App\Entity\Room;
use Symfony\Component\HttpClient\HttpClient;

class DonneesCapteurs
{
    private $donneesPourSalle ;
    private $donneesPourGraphique ;
    private $tags ;

    private function initTags()
    {
        $this->tags[1] = 'sae34bdx1eq1';
        $this->tags[2] = 'sae34bdx1eq2';
        $this->tags[3] = 'sae34bdx1eq3';
        $this->tags[4] = 'sae34bdx2eq1';
        $this->tags[5] = 'sae34bdx2eq2';
        $this->tags[6] = 'sae34bdx2eq3';
        $this->tags[7] = 'sae34bdy1eq1';
        $this->tags[8] = 'sae34bdy1eq2';
        $this->tags[9] = 'sae34bdy1eq3';
        $this->tags[10] = 'sae34bdy2eq1';
        $this->tags[11] = 'sae34bdy2eq2';
        $this->tags[12] = 'sae34bdy2eq3';
        $this->tags[13] = 'sae34bdz1eq1';
        $this->tags[14] = 'sae34bdz1eq2';
        $this->tags[15] = 'sae34bdz1eq3';
    }

    public function __construct()
    {
        $this->donneesPourSalle = array();
        $this->donneesPourGraphique = array();
        $this->tags = array();
        $this->initTags();

    }

    public function getDonneesPourSalle(int $tag):array
    {
        if($tag >0)
        {
            $types["T"] = "temp";
            $types["H"] = "hum";
            $types["C"] = "co2";

            $client = HttpClient::create();
            foreach ($types as $type => $nom) {
                $response = $client->request('GET', 'http://sae34.k8s.iut-larochelle.fr/api/captures/last?nom=' . $nom . '&tag=' . $tag . '&page=1', [
                    'headers' => [
                        'Accept' => 'application/ld+json',
                        'dbname' => $this->tags[$tag],
                        'username' => 'x1eq3',
                        'userpass' => 'bRepOh4UkiaM9c7R'
                    ],
                ]);
                if (sizeof(json_decode($response->getContent())) > 0) {
                    // rajouter maj de alert dans room
                    $this->donneesPourSalle[$type] = json_decode($response->getContent())[0];
                } else {
                    $this->donneesPourSalle[$type] = (object)array('valeur' => 'NULL', 'dateCapture' => 'NULL');
                }
            }
        }

        return $this->donneesPourSalle ;
    }

    public function getDonneesPourGraphique(int $tag):array
    {

        $types["T"] = "temp";
        $types["H"] = "hum";
        $types["C"] = "co2";
        $i=0;

        $client = HttpClient::create();
        foreach($types as $type => $nom)
        {
            var_dump($tag);
            $response = $client->request('GET', 'http://sae34.k8s.iut-larochelle.fr/api/captures?nom='.$nom.'&tag='.$tag.'&page=1', [
                'headers' => [
                    'Accept' => 'application/ld+json',

                    'dbname' => $this->tags[$tag],
                    'username' => 'x1eq3',
                    'userpass' => 'bRepOh4UkiaM9c7R'
                ],
            ]);
            if(sizeof(json_decode($response->getContent())) > 0)
            {
                //echo sizeof(json_decode($response->getContent()));

                foreach(json_decode($response->getContent()) as $data => $array) {
                    //var_dump(sizeof($array));

                    $this->donneesPourGraphique[$type][$data] = $array;
                    //echo $data;

                }
            }
            else{
                $this->donneesPourGraphique[$type] = (object) array('valeur' => 'NULL', 'dateCapture' => 'NULL');
            }
        }

        return $this->donneesPourGraphique ;
    }

    public function getDonneesPourHistoriqueAlerte(int $tag):array
    {
        if($tag >0) {
            var_dump($tag);

            $types["T"] = "temp";
            $types["H"] = "hum";
            $types["C"] = "co2";

            $client = HttpClient::create();
            foreach ($types as $type => $nom) {
                $response = $client->request('GET', 'http://sae34.k8s.iut-larochelle.fr/api/captures?nom=' . $nom . '&tag=' . $tag . '&page=1', [
                    'headers' => [
                        'Accept' => 'application/ld+json',
                        'dbname' => $this->tags[$tag],
                        'username' => 'x1eq3',
                        'userpass' => 'bRepOh4UkiaM9c7R'
                    ],
                ]);

                $json_response = array();
                $json_response = json_decode($response->getContent());

                if (sizeof($json_response) > 0) {
                    //echo sizeof(json_decode($response->getContent()));

                    foreach(json_decode($response->getContent()) as $data => $array) {
                        //var_dump(sizeof($array));

                        $this->donneesPourGraphique[$type][$data] = $array;
                        //echo $data;

                    }
                } else {
                    $this->donneesPourGraphique[$type] = (object)array('valeur' => 'NULL', 'dateCapture' => 'NULL');
                }
            }
        }

        return $this->donneesPourGraphique ;
    }
}