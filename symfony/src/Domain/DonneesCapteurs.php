<?php

namespace App\Domain;

use App\Entity\Room;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Stopwatch\Stopwatch;

class DonneesCapteurs
{
    private $donneesPourSalle ;
    private $donneesPourSelection ;
    private $donneesPourGraphique ;
    private $donneesPourInterval ;

    /**
     * @param array $donneesPourInterval
     */
    public function setDonneesPourInterval(array $donneesPourInterval): void
    {
        $this->donneesPourInterval = $donneesPourInterval;
    }
    private $tags ;
    private $stopwatch;


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

    public function __construct(Stopwatch $stopwatch)
    {
        $this->donneesPourSalle = array();
        $this->donneesPourGraphique = array();
        $this->donneesPourInterval = array();
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
                $response = $client->request('GET', 'http://sae34.k8s.iut-larochelle.fr/api/captures/last?nom=' . $nom . '&page=1', [
                    'headers' => [
                        'Accept' => 'application/ld+json',
                        'dbname' => $this->tags[$tag],
                        'username' => 'x1eq3',
                        'userpass' => 'bRepOh4UkiaM9c7R'
                    ],
                ]);
                $content=$response->getContent();
                if (sizeof(json_decode($content)) > 0) {
                    // rajouter maj de alert dans room
                    $this->donneesPourSalle[$type] = json_decode($content)[0];
                } else {
                    $this->donneesPourSalle[$type] = (object)array('valeur' => 'NULL', 'dateCapture' => 'NULL');
                }
            }
        }
        return $this->donneesPourSalle ;
    }

    public function  getDonneesInterval($tag,$date1,$date2):array
    {

            //date sous cette forme : 2023-01-08 YYYY-MM-DD
            $types["T"] = "temp";
            $types["H"] = "hum";
            $types["C"] = "co2";
            //tag défini par le dbname

            $client = HttpClient::create();
            foreach ($types as $type => $nom)
            {
                //var_dump($nom);
                $response = $client->request('GET', 'http://sae34.k8s.iut-larochelle.fr/api/captures/interval?nom='.$nom.'&date1='.$date1.'&date2='.$date2.'&page=1', [
                    'headers' => [
                        'Accept' => 'application/ld+json',
                        'dbname' => $this->tags[$tag],
                        'username' => 'x1eq3',
                        'userpass' => 'bRepOh4UkiaM9c7R'
                    ],
                ]);
                $content = json_decode($response->getContent());
                //echo 'le content :' ;
                if (sizeof($content) > 0 and $tag != 8)
                {
                    foreach ($content as $data => $array)
                    {
                        $arrayMieux = json_decode(json_encode($array), true);
                        if ($arrayMieux["nom"] == $nom and $arrayMieux["tag"] == $tag)
                        {
                            $this->donneesPourInterval[$type][$data] = $arrayMieux;
                        }
                    }
                }
                else{
                    $this->donneesPourInterval[$type][0] = array("valeur" => "NULL", "dateCapture" => "NULL");
                }
            }
        return $this->donneesPourInterval ;
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
}