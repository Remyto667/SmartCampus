<?php


namespace App\Domain\Stat;

class Stat
{
    private $moyJanvier=array();
    private $moyFevrier=array();
    private $moyMars=array();
    private $moyAvril=array();
    private $moyMai=array();
    private $moyJuin=array();
    private $moyJuillet=array();
    private $moyAout=array();
    private $moySeptembre=array();
    private $moyOctobre=array();
    private $moyNovembre=array();
    private $moyDecembre=array();


    public function transformMonth($DateCapture): ?string
    {
        $arrayDateCapture = explode(" ", $DateCapture);

        $arrayDate =  explode('-', $arrayDateCapture[0]);

        //dd($arrayDate);

        return $arrayDate[1];
    }

    public function PushToArrayDateMonth($date, $valeur): void
    {


        switch($date){

            case 1: $moyJanvier[] = $valeur;
            case 2: $moyFevrier[] = $valeur;
            case 3: $moyMars[] = $valeur;
            case 4: $moyAvril[] = $valeur;
            case 5: $moyMai[] = $valeur;
            case 6: $moyJuin[] = $valeur;
            case 7: $moyJuillet[] = $valeur;
            case 8: $moyAout[] = $valeur;
            case 9: $moySeptembre[] = $valeur;
            case 10: $moyOctobre[] = $valeur;
            case 11: $moyNovembre[] = $valeur;
            case 12: $moyDecembre[] = $valeur;
        }

    }



    /**
     * @return array
     */
    public function getMoyJanvier(): array
    {
        return $this->moyJanvier;
    }

    /**
     * @return array
     */
    public function getMoyFevrier(): array
    {
        return $this->moyFevrier;
    }

    /**
     * @return array
     */
    public function getMoyMars(): array
    {
        return $this->moyMars;
    }

    /**
     * @return array
     */
    public function getMoyAvril(): array
    {
        return $this->moyAvril;
    }

    /**
     * @return array
     */
    public function getMoyMai(): array
    {
        return $this->moyMai;
    }

    /**
     * @return array
     */
    public function getMoyJuin(): array
    {
        return $this->moyJuin;
    }

    /**
     * @return array
     */
    public function getMoyJuillet(): array
    {
        return $this->moyJuillet;
    }

    /**
     * @return array
     */
    public function getMoyAout(): array
    {
        return $this->moyAout;
    }

    /**
     * @return array
     */
    public function getMoySeptembre(): array
    {
        return $this->moySeptembre;
    }

    /**
     * @return array
     */
    public function getMoyOctobre(): array
    {
        return $this->moyOctobre;
    }

    /**
     * @return array
     */
    public function getMoyNovembre(): array
    {
        return $this->moyNovembre;
    }

    /**
     * @return array
     */
    public function getMoyDecembre(): array
    {
        return $this->moyDecembre;
    }



}




// Je montre la moyenne sur 2h (8 captures pour 1 jours) et j'affiche 8 points (8h-10h-12h-14h-16h-18h-20h-22h) tous les semaines

// moyenne de 8h tous les mois (8 captures pour 1 mois) et j'affiche 8 points (8h -16h -24h)

// Je montre une capture toutes les 15 minutes (sur un jours)