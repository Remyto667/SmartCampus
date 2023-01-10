<?php

namespace App\Domain\Query;

use App\Repository\ConseilRepository;
use App\Domain\DonneesCapteurs;
use Doctrine\Persistence\ManagerRegistry;

class ConseilAlerteHandler
{
    private $donneesCapteurs;

    public function __construct(DonneesCapteurs $donneesCapteurs)
    {
        $this->donneesCapteurs = $donneesCapteurs;
    }

    public function typeOfAlert($data, $requete)
    {
        //récupératoin des valeurs
        $temp = $data["T"]->valeur;
        $hum = $data["H"]->valeur;
        $co2 = $data["C"]->valeur;
        //récupération du type des salles
        $roomType = $requete->getRoom()->getType();
        //Valeurs pour le type de conseils
        $temp_alerte_sup = false;
        $temp_alerte_inf = false;
        $hum_alerte_sup = false;
        $hum_alerte_inf = false;
        $co2_alerte_sup = false;
        $co2_alerte_inf = false;
        $temp_sup_outside = false;
        $no_data = false;


        if($temp > $roomType->getTempMax())
        {
            $temp_alerte_sup = true;
        }
        if($temp < $roomType->getTempMin())
        {
            $temp_alerte_inf = true;
        }
        if($hum > $roomType->getHumMax())
        {
            $hum_alerte_sup = true;
        }
        if($hum < $roomType->getHumMin())
        {
            $hum_alerte_inf = true;
        }
        if($co2 >= $roomType->getCo2Max())
        {
            $co2_alerte_sup = true;
        }
        if($co2 < $roomType->getCo2Min())
        {
            $co2_alerte_inf = true;
        }

        //appel du repository et renvoie du conseil
        $a = $requete->getAdvice($temp_alerte_sup,$temp_alerte_inf,$hum_alerte_sup,$hum_alerte_inf,$co2_alerte_sup,$co2_alerte_inf,$temp_sup_outside,$no_data);

        return $a;

    }

    public function handle(ConseilAlerteQuery $requete)
    {
        $data = $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());

        //récupere la donnée (donnée du repository)
        //renvoie le conseil
        return $this->typeOfAlert($data, $requete);

    }
}