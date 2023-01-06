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

        switch ($roomType){
            case 0:case 1:case 3:case 4:
                $tempMin=16; $tempMax=24;$humMin=41; $humMax=59;
                break;
            case 2:
                $tempMin=10; $tempMax=18;$humMin=38; $humMax=50;
                break;
            default:
                $tempMin=0; $tempMax=100;$humMin=0; $humMax=100;
        }

        if(($temp > $tempMax) or ($temp < $tempMin))
        {
            $requete->getRoom()->setTempAlert(new Alert(true, $tempDate));
            $requete->getRoom()->getTempAlert()->setIsAlert(true);
        }
        else{
            $requete->getRoom()->setTempAlert(new Alert(false, ''));
        }
        if($hum > $humMax or $hum < $humMin)
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

    public function handleGraph(DonneesCapteursQuery $requete)
    {
        $data = $this->donneesCapteurs->getDonneesPourGraphique($requete->getTag());
        return $data;
    }


}