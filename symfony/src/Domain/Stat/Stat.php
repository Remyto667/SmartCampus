<?php


namespace App\Domain\Stat;

namespace App\Domain\Stat;

class Stat
{
    private $moyJanvier;
    private $moyFevrier;
    private $moyMars;
    private $moyAvril;
    private $moyMai;
    private $moyJuin;
    private $moyJuillet;
    private $moyAout;
    private $moySeptembre;
    private $moyOctobre;
    private $moyNovembre;
    private $moyDecembre;

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
        if(sizeof($arrayMoy)>0) {
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


    public function PopulateMoy() : void {

        $this->moyJanvier=($this->PushToArrayMoy($this->dataJanvier));
        $this->moyFevrier=($this->PushToArrayMoy($this->dataFevrier));
        $this->moyMars=($this->PushToArrayMoy($this->dataMars));
        $this->moyAvril=($this->PushToArrayMoy($this->dataAvril));
        $this->moyMai=($this->PushToArrayMoy($this->dataMai));
        $this->moyJuin=($this->PushToArrayMoy($this->dataJuin));
        $this->moyJuillet=($this->PushToArrayMoy($this->dataJuillet));
        $this->moyAout=($this->PushToArrayMoy($this->dataAout));
        $this->moySeptembre=($this->PushToArrayMoy($this->dataSeptembre));
        $this->moyOctobre=($this->PushToArrayMoy($this->dataOctobre));
        $this->moyNovembre=($this->PushToArrayMoy($this->dataNovembre));
        $this->moyDecembre=($this->PushToArrayMoy($this->dataDecembre));


    }



    /**
     * @return float
     */
    public function getMoyJanvier(): ?float
    {
        return $this->moyJanvier;
    }

    /**
     * @return float
     */
    public function getMoyFevrier(): ?float
    {
        return $this->moyFevrier;
    }

    /**
     * @return float
     */
    public function getMoyMars(): ?float
    {
        return $this->moyMars;
    }

    /**
     * @return float
     */
    public function getMoyAvril(): ?float
    {
        return $this->moyAvril;
    }

    /**
     * @return float
     */
    public function getMoyMai(): ?float
    {
        return $this->moyMai;
    }

    /**
     * @return float
     */
    public function getMoyJuin(): ?float
    {
        return $this->moyJuin;
    }

    /**
     * @return float
     */
    public function getMoyJuillet(): ?float
    {
        return $this->moyJuillet;
    }

    /**
     * @return float
     */
    public function getMoyAout(): ?float
    {
        return $this->moyAout;
    }

    /**
     * @return float
     */
    public function getMoySeptembre(): ?float
    {
        return $this->moySeptembre;
    }

    /**
     * @return float
     */
    public function getMoyOctobre(): ?float
    {
        return $this->moyOctobre;
    }

    /**
     * @return float
     */
    public function getMoyNovembre(): ?float
    {
        return $this->moyNovembre;
    }

    /**
     * @return float
     */
    public function getMoyDecembre(): ?float
    {
        return $this->moyDecembre;
    }



}




// Je montre la moyenne sur 2h (8 captures pour 1 jours) et j'affiche 8 points (8h-10h-12h-14h-16h-18h-20h-22h) tous les semaines

// moyenne de 8h tous les mois (8 captures pour 1 mois) et j'affiche 8 points (8h -16h -24h)

// Je montre une capture toutes les 15 minutes (sur un jours)