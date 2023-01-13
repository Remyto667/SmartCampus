<?php

namespace App\Domain\Query;

use App\Domain\Alert;
use App\Domain\DonneesCapteurs;
use Symfony\Component\Stopwatch\Stopwatch;

class DonneesCapteursHandler
{
    private DonneesCapteurs $donneesCapteurs;

    public function __construct(DonneesCapteurs $donneesCapteurs)
    {
        $this->donneesCapteurs = $donneesCapteurs;
    }

    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function isItAlert(array $data, DonneesCapteursQuery $requete): void
    {
        $temp = $data["T"]->valeur;
        $hum = $data["H"]->valeur;
        $co2 = $data["C"]->valeur;
        $roomType = $requete->getRoom()->getType();

        if (($temp <= $roomType->getTempMin()) or ($temp > $roomType->getTempMax()) or $hum >= $roomType->getHumMax() or $hum < $roomType->getHumMin() or $co2 >= $roomType->getCo2Max() or $co2  < $roomType->getCo2Min()) {
            $requete->getRoom()->setIsAlert(true);
        }
        else {
            $requete->getRoom()->setIsAlert(false);
        }
    }
    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertTemp(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if ($temp < $roomType->getTempMin() or ($temp > $roomType->getTempMax())) {
            $nb += 1;
        }
        return $nb;
    }
    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertCo2(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp < $roomType->getCo2Min() or ($temp > $roomType->getCo2Max())) {
            $nb += 1;
        }
        return $nb;
    }

    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertHum(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp < $roomType->getHumMin() or ($temp > $roomType->getHumMax())) {
            $nb += 1;
        }
        return $nb;
    }

    /**
     * @return array<mixed>
     */
    public function handle(DonneesCapteursQuery $requete): array
    {
        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());

        $this->isItAlert($data, $requete);
        return $data;
    }

    /**
     * @return array<mixed>
     */
    public function handleGraph(DonneesCapteursQuery $requete): array
    {
        $data = $this->donneesCapteurs->getDonneesPourGraphique($requete->getTag());
        return $data;
    }

    /**
     * @return array<mixed>
     */
    public function handleNbAlert(DonneesCapteursQuery $requete,string $date1,string $date2):array
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