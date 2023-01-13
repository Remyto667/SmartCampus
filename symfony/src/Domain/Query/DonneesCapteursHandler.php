<?php

namespace App\Domain\Query;

use App\Domain\Alert;
use App\Domain\DonneesCapteurs;
use Symfony\Component\Stopwatch\Stopwatch;

class DonneesCapteursHandler
{
    private $donneesCapteurs;
    private $stopwatch;

    public function __construct(DonneesCapteurs $donneesCapteurs, Stopwatch $stopwatch)
    {
        $this->donneesCapteurs = $donneesCapteurs;
        $this->stopwatch = $stopwatch;

    }

    public function isItAlert($data, $requete)
    {
        $temp = $data["T"]->valeur;
        $hum = $data["H"]->valeur;
        $co2 = $data["C"]->valeur;
        $roomType = $requete->getRoom()->getType();

        if(($temp <= $roomType->getTempMin()) or ($temp > $roomType->getTempMax()) or $hum >= $roomType->getHumMax() or $hum < $roomType->getHumMin() or $co2 >= $roomType->getCo2Max() or $co2  < $roomType->getCo2Min())
        {
            $requete->getRoom()->setIsAlert(true);
        }
        else{
            $requete->getRoom()->setIsAlert(false);
        }
    }

    //return 1 if the value is not between what's expected
    public function countAlertTemp($data, $requete):int
    {
        $nb=0;
        //take the type of room
        $roomType = $requete->getRoom()->getType();
        //if this is good data
        if ($data["nom"]=="temp"){
            $temp = $data['valeur'];
            //verification for the value
            if($temp < $roomType->getTempMin() or ($temp > $roomType->getTempMax()))
            {
                //if it is too much or too little add 1
                $nb+=1;
            }
        }
        //return the 1 or the 0 to know if there is an alert for this data
        return $nb;
    }

    //return 1 if the value is not between what's expected
    public function countAlertCo2($data, $requete):int
    {
        $nb=0;
        //take the type of room
        $roomType = $requete->getRoom()->getType();
        //if this is good data
        if ($data["nom"]=="co2"){
            $temp = $data['valeur'];
            //verification for the value
            if($temp < $roomType->getCo2Min() or ($temp > $roomType->getCo2Max()))
            {
                //if it is too much or too little add 1
                $nb+=1;
            }
        }
        //return the 1 or the 0 to know if there is an alert for this data
        return $nb;
    }

    //return 1 if the value is not between what's expected
    public function countAlertHum($data, $requete):int
    {
        $nb=0;
        //take the type of room
        $roomType = $requete->getRoom()->getType();
        //if this is good data
        if ($data["nom"]=="hum") {
            $temp = $data['valeur'];
            //verification for the value
            if ($temp < $roomType->getHumMin() or ($temp > $roomType->getHumMax())) {
                //if it is too much or too little add 1
                $nb += 1;
            }
        }
        //return the 1 or the 0 to know if there is an alert for this data
        return $nb;
    }

    public function handle(DonneesCapteursQuery $requete)
    {
        $this->stopwatch->start('export-data');

        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());
        $this->stopwatch->stop('export-data');

        $this->isItAlert($data, $requete);
        return $data;
    }

    public function handleGraph(DonneesCapteursQuery $requete)
    {
        $data = $this->donneesCapteurs->getDonneesPourGraphique($requete->getTag());
        return $data;
    }


    //count the number of alert for a specific room
    public function handleNbAlert(DonneesCapteursQuery $requete,$date1,$date2):array
    {
        //clear the array
        $tempArray = array() ;
        $this->donneesCapteurs->setDonneesPourInterval($tempArray);

        //call to get the datas
        $datas = $this->donneesCapteurs->getDonneesInterval($requete->getTag(),$date1,$date2);

        //the array we return
        $nbAlert=array();
        //number of alert initialization
        $nb=0;

        //verify that there is data to work with
        if ($datas["T"][0]["valeur"] != "NULL")
        {
            //only take the one that correspond as temperature
            foreach ($datas["T"] as $data)
            {
                //add 1 to this number if the value is not good
                $nb+=$this->countAlertTemp($data, $requete);
            }
        }
        //put this number into the ["T"] box
        $nbAlert["T"] = $nb;
        //reset nb for the others data type
        $nb = 0;

        //verify that there is data to work with
        if($datas["H"][0]["valeur"] != "NULL")
        {
            //only take the one that correspond as humidity
            foreach ($datas["H"] as $data)
            {
                //add 1 to this number if the value is not good
                $nb += $this->countAlertHum($data, $requete);
            }
        }
        //put this number into the ["H"] box
        $nbAlert["H"] =$nb;
        //reset nb for the others data type
        $nb=0;

        //verify that there is data to work with
        if($datas["C"][0]["valeur"] != "NULL")
        {
            //only take the one that correspond as Co2
            foreach ($datas["C"] as $data)
            {
                //add 1 to this number if the value is not good
                $nb += $this->countAlertCo2($data, $requete);
            }
        }
        //put this number into the ["C"] box
        $nbAlert["C"] =$nb;

        //return the array
        return $nbAlert;
    }

}