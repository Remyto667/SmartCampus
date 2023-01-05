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

        if($temp > 24 or $temp < 16)
        {
            $requete->getRoom()->setTempAlert(new Alert(true, $data["T"]->dateCapture));
        }
        else{
            $requete->getRoom()->setTempAlert(new Alert(false, ''));
        }
        if($hum > 59 or $hum < 41)
        {
            $requete->getRoom()->setHumAlert(new Alert(true, $data["H"]->dateCapture));
        }
        else{
            $requete->getRoom()->setHumAlert(new Alert(false, ''));
        }
        if($co2 >= 800)
        {
            $requete->getRoom()->setCo2Alert(new Alert(true, $data["C"]->dateCapture));
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