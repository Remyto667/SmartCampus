<?php


namespace App\Domain\Stat;

namespace App\Domain\Stat;

class Stat
{
    private $moyAllMonth = array();

    private $dataJanvier= array();
    private $dataFevrier= array();
    private $dataMars= array();
    private $dataAvril= array();
    private $dataMai= array();
    private $dataJuin= array();
    private $dataJuillet= array();
    private $dataAout= array();
    private $dataSeptembre= array();
    private $dataOctobre= array();
    private $dataNovembre= array();
    private $dataDecembre= array();



    public function transformMonth($dateCapture): ?string
    {
        $arrayDateCapture = explode(" ", $dateCapture);

        $arrayDate =  explode('-', $arrayDateCapture[0]);

        return $arrayDate[1];
    }

    public function PushToArrayMoy($arrayMoy):float
    {
        $cpp=0;

        foreach($arrayMoy as $data){

            $cpp+=$data;
        }
        if(sizeof($arrayMoy)>0 ) {
            $moy = ($cpp / sizeof($arrayMoy));
        }
        else{
            $moy=0;
        }

        return $moy;

    }


    public function PushToArrayDateMonth($date, $valeur): void
    {

        switch($date){

            case 1: $this->dataJanvier[] = $valeur;
            break;

            case 2: $this->dataFevrier[] = $valeur;
            break;

            case 3: $this->dataMars[] = $valeur;
            break;

            case 4: $this->dataAvril[] = $valeur;
            break;

            case 5: $this->dataMai[] = $valeur;
            break;

            case 6: $this->dataJuin[] = $valeur;
            break;

            case 7: $this->dataJuillet[] = $valeur;
            break;

            case 8: $this->dataAout[] = $valeur;
            break;

            case 9: $this->dataSeptembre[] = $valeur;
            break;

            case 10: $this->dataOctobre[] = $valeur;
            break;

            case 11: $this->dataNovembre[] = $valeur;
            break;

            case 12: $this->dataDecembre[] = $valeur;
            break;
        }

        //dd($dataJanvier);
    }


    public function PopulateMoy() : array {

        //dd($this->dataJanvier);

        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataJanvier));


        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataFevrier));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataMars));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataAvril));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataMai));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataJuin));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataJuillet));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataAout));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataSeptembre));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataOctobre));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataNovembre));
        $this->moyAllMonth[]=($this->PushToArrayMoy($this->dataDecembre));

        //dd($this->moyJanvier);

        return $this->moyAllMonth;


    }





}




// Je montre la moyenne sur 2h (8 captures pour 1 jours) et j'affiche 8 points (8h-10h-12h-14h-16h-18h-20h-22h) tous les semaines

// moyenne de 8h sur un mois (8 captures pour 1 mois) et j'affiche 8 points (8h -16h -24h)

// Je montre une capture toutes les 15 minutes (sur un jours)

// 96 data