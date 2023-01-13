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
        $temp = $data['valeur'];
        if($temp < $roomType->getTempMin() or ($temp > $roomType->getTempMax()))
        {
            $nb+=1;
        }
        return $nb;
    }
    public function countAlertCo2($data, $requete):int
    {
        $nb=0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp < $roomType->getCo2Min() or ($temp > $roomType->getCo2Max()))
        {
            $nb+=1;
        }
        return $nb;
    }
    public function countAlertHum($data, $requete):int
    {
        $nb=0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp < $roomType->getHumMin() or ($temp > $roomType->getHumMax()))
        {
            $nb+=1;
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

    public function handleInterval(DonneesCapteursQuery $requete,$date1,$date2){
        $data = $this->donneesCapteurs->getDonneesIntervalGraph($requete->getTag(),$date1,$date2);
        return $data;
    }

    public function handleNbAlertTemp(DonneesCapteursQuery $requete,$date1,$date2):int
    {
        $datas = $this->donneesCapteurs->getDonneesInterval($requete->getTag(),$date1,$date2);
        $nb=0;
        //faut n'envoyer que les donnees dans le array $datas qui sont dans ["T"]
        if(gettype($datas["T"][0]) != "object")
        {
            foreach ($datas["T"] as $data)
            {
                $nb += $this->countAlertTemp($data, $requete);
            }
        }

        return $nb;
    }
    public function handleNbAlertHum(DonneesCapteursQuery $requete,$date1,$date2):int
    {
        $datas = $this->donneesCapteurs->getDonneesInterval($requete->getTag(),$date1,$date2);
        $nb=0;
        //faut n'envoyer que les donnees dans le array $datas qui sont dans ["H"]
        if(gettype($datas["H"][0]) != "object")
        {
            foreach ($datas["H"] as $data)
            {
                $nb += $this->countAlertHum($data, $requete);
            }
        }
        return $nb;
    }
    public function handleNbAlertCo2(DonneesCapteursQuery $requete,$date1,$date2):int
    {
        $datas = $this->donneesCapteurs->getDonneesInterval($requete->getTag(),$date1,$date2);
        $nb=0;
        //faut n'envoyer que les donnees dans le array $datas qui sont dans ["C"]
        if(gettype($datas["C"][0]) != "object")
        {
            foreach ($datas["C"] as $data)
            {
                $nb += $this->countAlertCo2($data, $requete);
            }
        }
        return $nb;
    }


}