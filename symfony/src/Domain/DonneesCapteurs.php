<?php

namespace App\Domain;

use App\Entity\Room;

class DonneesCapteurs
{
    private $donneesPourSalle ;

    public function __construct()
    {
        $this->donneesPourSalle = array();
    }

    public function getDonneesPourSalle(Room $room):array
    {
        $types["T"] = "-temp.json";
        $types["H"] = "-hum.json";
        $types["C"] = "-co2.json";

        foreach($types as $type => $nom)
        {
            $json = "../assets/json/".$room->getName().$nom;
            $file = file_get_contents($json);
            $this->donneesPourSalle[$type] = json_decode($file)[0];
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