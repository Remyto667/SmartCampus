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

    public function countAlertTemp($data, $requete):int
    {
        $nb=0;
        $roomType = $requete->getRoom()->getType();
        if ($data["nom"]=="temp"){
            $temp = $data['valeur'];
            if($temp < $roomType->getTempMin() or ($temp > $roomType->getTempMax()))
            {
                $nb+=1;
            }
        }
//echo $nb;
        return $nb;
    }
    public function countAlertCo2($data, $requete):int
    {
        $nb=0;
        $roomType = $requete->getRoom()->getType();
        if ($data["nom"]=="co2"){
            $temp = $data['valeur'];
            if($temp < $roomType->getCo2Min() or ($temp > $roomType->getCo2Max()))
            {
                $nb+=1;
            }
        }
        return $nb;
    }
    public function countAlertHum($data, $requete):int
    {
        $nb=0;
        $roomType = $requete->getRoom()->getType();
        if ($data["nom"]=="hum") {
            $temp = $data['valeur'];
            if ($temp < $roomType->getHumMin() or ($temp > $roomType->getHumMax())) {
                $nb += 1;
            }
        }
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


    public function handleNbAlert(DonneesCapteursQuery $requete,$date1,$date2):array
    {
        $tempArray = array() ;
        $this->donneesCapteurs->setDonneesPourInterval($tempArray);
        $datas = $this->donneesCapteurs->getDonneesInterval($requete->getTag(),$date1,$date2);
        $nbAlert=array();
        $nb=0;

        //faut n'envoyer que les donnees dans le array $datas qui sont dans ["T"]
        if ($datas["T"][0]["valeur"] != "NULL")
        {
            foreach ($datas["T"] as $data)
            {
                if($this->countAlertTemp($data, $requete)==1)
                    $nb++ ;

            }

        }
        $nbAlert["T"] =$nb;
        $nb=0;
        //faut n'envoyer que les donnees dans le array $datas qui sont dans ["H"]
        if($datas["H"][0]["valeur"] != "NULL")
        {
            foreach ($datas["H"] as $data)
            {
                $nb += $this->countAlertHum($data, $requete);
            }

        }
        $nbAlert["H"] =$nb;
        $nb=0;
        //faut n'envoyer que les donnees dans le array $datas qui sont dans ["C"]
        if($datas["C"][0]["valeur"] != "NULL")
        {
            foreach ($datas["C"] as $data)
            {
                $nb += $this->countAlertCo2($data, $requete);
            }
        }
        $nbAlert["C"] =$nb;

        return $nbAlert;
    }

}