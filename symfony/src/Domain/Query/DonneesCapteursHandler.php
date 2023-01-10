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

    public function handleAlerte(DonneesCapteursQuery $requete)
    {
        $data = $this->donneesCapteurs->getDonneesPourHistoriqueAlerte(3);
        return $data;
    }


}