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

        if($temp > 24 or $temp < 16)
        {
            $requete->getRoom()->setTempAlert(new Alert(true, $tempDate));
            $requete->getRoom()->getTempAlert()->setIsAlert(true);
        }
        else{
            $requete->getRoom()->setTempAlert(new Alert(false, ''));
        }
        if($hum > 59 or $hum < 41)
        {
            $requete->getRoom()->setHumAlert(new Alert(true, $humDate));
        }
        else{
            $requete->getRoom()->setHumAlert(new Alert(false, ''));
        }
        if($co2 >= 800)
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
}