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
    public function countAlertTempMore(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if ($temp > $roomType->getTempMax()) {
            $nb += 1;
        }
        return $nb;
    }

    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertTempLess(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if ($temp < $roomType->getTempMin()) {
            $nb += 1;
        }
        return $nb;
    }

    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertCo2More(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp > $roomType->getCo2Max()) {
            $nb += 1;
        }
        return $nb;
    }

    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertCo2Less(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp < $roomType->getCo2Min()) {
            $nb += 1;
        }
        return $nb;
    }



    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertHumMore(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp > $roomType->getHumMax()) {
            $nb += 1;
        }
        return $nb;
    }

    /**
     * @param array<mixed> $data
     * @param DonneesCapteursQuery $requete
     */
    public function countAlertHumLess(array $data, DonneesCapteursQuery $requete): int
    {
        $nb = 0;
        $roomType = $requete->getRoom()->getType();
        $temp = $data['valeur'];
        if($temp < $roomType->getHumMin()) {
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
    public function handleInterval(DonneesCapteursQuery $requete, String $date1, String $date2):array
    {
        $data = $this->donneesCapteurs->getDonneesIntervalGraph($requete->getTag(),$date1,$date2);
        return $data;
    }


    /**
     * @return array<mixed>
     */
    public function handleNbAlert(DonneesCapteursQuery $requete,string $date1,string $date2):array
    {
        $nbAlert=array();
        $tempArray = array() ;
        $this->donneesCapteurs->setDonneesPourInterval($tempArray);
        if ($requete->getTag()!=0){
            $datas = $this->donneesCapteurs->getDonneesInterval($requete->getTag(),$date1,$date2);
        }


        $nb=0;
        $nb2=0;

        //if no system has been affected to the room yet
        if ($requete->getTag()!=0){
            //faut n'envoyer que les donnees dans le array $datas qui sont dans ["T"]
            if ($datas["T"][0]["valeur"] != "NULL")
            {
                foreach ($datas["T"] as $data)
                {
                    $nb += $this->countAlertTempMore($data, $requete);
                    $nb2 += $this->countAlertTempLess($data, $requete);
                }

            }
        }
        $nbAlert["T"]["More"] =$nb;
        $nbAlert["T"]["Less"] =$nb2;
        $nb=0;$nb2=0;
        //if no system has been affected to the room yet
        if ($requete->getTag()!=0){
            //faut n'envoyer que les donnees dans le array $datas qui sont dans ["H"]
            if($datas["H"][0]["valeur"] != "NULL")
            {
                foreach ($datas["H"] as $data)
                {
                    $nb += $this->countAlertHumMore($data, $requete);
                    $nb2 += $this->countAlertHumLess($data, $requete);
                }

            }
        }

        $nbAlert["H"]["More"] =$nb;
        $nbAlert["H"]["Less"] =$nb2;
        $nb=0;
        $nb2=0;
        //if no system has been affected to the room yet
        if ($requete->getTag()!=0){
            //faut n'envoyer que les donnees dans le array $datas qui sont dans ["C"]
            if($datas["C"][0]["valeur"] != "NULL")
            {
                foreach ($datas["C"] as $data)
                {
                    $nb += $this->countAlertCo2More($data, $requete);
                    $nb2 += $this->countAlertCo2Less($data, $requete);
                }
            }
        }

        $nbAlert["C"]["More"] =$nb;
        $nbAlert["C"]["Less"] =$nb2;
        return $nbAlert;
    }
}