<?php

namespace App\Domain\Query;

use App\Domain\Alert;
use App\Domain\DonneesCapteurs;

class DonneesCapteursHandler
{
    private $donneesCapteurs;

    public function __construct(DonneesCapteurs $donneesCapteurs)
    {
        $this->donneesCapteurs = $donneesCapteurs;
    }

    public function isItAlert($data, $requete)
    {
        $temp = $data["T"]->valeur;
        $hum = $data["H"]->valeur;
        $co2 = $data["C"]->valeur;
        $tempDate = $data["T"]->dateCapture;
        $humDate = $data["H"]->dateCapture;
        $co2Date = $data["C"]->dateCapture;
        $roomType = $requete->getRoom()->getType();

        if(($temp <= $roomType->getTempMin()) or ($temp > $roomType->getTempMax()))
        {
            $requete->getRoom()->setTempAlert(new Alert(true, $tempDate));
            $requete->getRoom()->getTempAlert()->setIsAlert(true);
        }
        else{
            $requete->getRoom()->setTempAlert(new Alert(false, ''));
        }
        if($hum >= $roomType->getHumMax() or $hum < $roomType->getHumMin())
        {
            $requete->getRoom()->setHumAlert(new Alert(true, $humDate));
        }
        else{
            $requete->getRoom()->setHumAlert(new Alert(false, ''));
        }
        if($co2 >= $roomType->getCo2Max() or $co2  < $roomType->getCo2Min())
        {
            $requete->getRoom()->setCo2Alert(new Alert(true, $co2Date));
        }
        else{
            $requete->getRoom()->setCo2Alert(new Alert(false, ''));
        }
    }

    public function countAlertTemp($data, $requete):int
    {
        $nb=0;
        $temp = $data["T"]->valeur;
        $roomType = $requete->getRoom()->getType();
        if(($temp <= $roomType->getTempMin()) or ($temp > $roomType->getTempMax()))
        {
            $nb+=1;
        }
        return $nb;
    }
    public function countAlertCo2($data, $requete):int
    {
        $nb=0;
        $co2 = $data["C"]->valeur;
        $roomType = $requete->getRoom()->getType();
        if(($co2 <= $roomType->getCo2Min()) or ($co2 > $roomType->getCo2Max()))
        {
            $nb+=1;
        }
        return $nb;
    }
    public function countAlertHum($data, $requete):int
    {
        $nb=0;
        $hum = $data["H"]->valeur;
        $roomType = $requete->getRoom()->getType();
        if(($hum <= $roomType->getHumMin()) or ($hum > $roomType->getHumMax()))
        {
            $nb+=1;
        }
        return $nb;
    }

    public function handle(DonneesCapteursQuery $requete)
    {
        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());
        $this->isItAlert($data, $requete);
        return $data;
    }

    public function handleGraph(DonneesCapteursQuery $requete)
    {
        $data = $this->donneesCapteurs->getDonneesPourGraphique($requete->getTag());
        return $data;
    }

    public function handleNbAlertTemp(DonneesCapteursQuery $requete):int
    {
        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());
        return $this->countAlertTemp($data, $requete);
    }
    public function handleNbAlertHum(DonneesCapteursQuery $requete):int
    {
        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());
        return $this->countAlertHum($data, $requete);
    }
    public function handleNbAlertCo2(DonneesCapteursQuery $requete):int
    {
        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());
        return $this->countAlertCo2($data, $requete);
    }


}