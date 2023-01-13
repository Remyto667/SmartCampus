<?php

namespace App\Domain\Stat;
namespace App\Domain\Stat;

class Stat
{
    private $moyAllMonth = array();
    private $allDay = array();

    private $dataJanvier = array();
    private $dataFevrier = array();
    private $dataMars = array();
    private $dataAvril = array();
    private $dataMai = array();
    private $dataJuin = array();
    private $dataJuillet = array();
    private $dataAout = array();
    private $dataSeptembre = array();
    private $dataOctobre = array();
    private $dataNovembre = array();
    private $dataDecembre = array();



    public function transformMonth($dateCapture): ?string
    {
        $arrayDateCapture = explode(" ", $dateCapture);

        $arrayDate =  explode('-', $arrayDateCapture[0]);

        return $arrayDate[1];
    }

    public function transformDay($dateCapture): ?array
    {
        $arrayDateCapture = explode(" ", $dateCapture);

        $arrayDate = explode('-', $arrayDateCapture[0]);

        $arrayResult[] = $arrayDate[2];
        $arrayResult[] = $arrayDateCapture[1];

        return $arrayResult;
    }

    public function pushToArrayMoy($arrayMoy):float
    {
        $cpp = 0;

        foreach ($arrayMoy as $data){
            $cpp += $data;
        }
        if (sizeof($arrayMoy) > 0 ) {
            $moy = ($cpp / sizeof($arrayMoy));
        }
        else {
            $moy = 0;
        }

        return $moy;
    }


    public function pushToArrayDateMonth($date, $valeur): void
    {
        switch ($date) {
            case 1:
                $this->dataJanvier[] = $valeur; break;

            case 2:
                $this->dataFevrier[] = $valeur; break;

            case 3:
                $this->dataMars[] = $valeur; break;

            case 4:
                $this->dataAvril[] = $valeur; break;

            case 5:
                $this->dataMai[] = $valeur; break;

            case 6:
                $this->dataJuin[] = $valeur; break;

            case 7:
                $this->dataJuillet[] = $valeur; break;

            case 8:
                $this->dataAout[] = $valeur; break;

            case 9:
                $this->dataSeptembre[] = $valeur; break;

            case 10:
                $this->dataOctobre[] = $valeur; break;

            case 11:
                $this->dataNovembre[] = $valeur; break;

            case 12:
                $this->dataDecembre[] = $valeur; break;
        }
    }

    public function pushToArrayDateDay($date, $valeur): void
    {

        //dd($date);
        //dd($valeur);

        switch($date[0]){

            case 1:
                $this->allDay[1][] = $date[1];
                $this->allDay[1][] = $valeur;
                break;

            case 2:
                $this->allDay[2][] = $date[1];
                $this->allDay[2][] = $valeur;
                break;

            case 3:
                $this->allDay[3][] = $date[1];
                $this->allDay[3][] = $valeur;
                break;

            case 4:
                $this->allDay[4][] = $date[1];
                $this->allDay[4][] = $valeur;

                break;

            case 5:
                $this->allDay[5][] = $date[1];
                $this->allDay[5][] = $valeur;
                break;

            case 6:
                $this->allDay[6][] = $date[1];
                $this->allDay[6][] = $valeur;
                break;

            case 7:
                $this->allDay[7][] = $date[1];
                $this->allDay[7][] = $valeur;
                break;

            case 8:
                $this->allDay[8][] = $date[1];
                $this->allDay[8][] = $valeur;
                break;

            case 9:
                $this->allDay[9][] = $date[1];
                $this->allDay[9][] = $valeur;
                break;

            case 10:
                $this->allDay[10][] = $date[1];
                $this->allDay[10][] = $valeur;
                break;

            case 11:
                $this->allDay[11][] = $date[1];
                $this->allDay[11][] = $valeur;
                break;

            case 12:
                $this->allDay[12][] = $date[1];
                $this->allDay[12][] = $valeur;
                break;

            case 13:
                $this->allDay[13][] = $date[1];
                $this->allDay[13][] = $valeur;
                break;

            case 14:
                $this->allDay[14][] = $date[1];
                $this->allDay[14][] = $valeur;
                break;

            case 15:
                $this->allDay[15][] = $date[1];
                $this->allDay[15][] = $valeur;

                break;

            case 16:
                $this->allDay[16][] = $date[1];
                $this->allDay[16][] = $valeur;
                break;

            case 17: $this->allDay[17][] = $date[1];
                $this->allDay[17][] = $valeur;
                break;

            case 18:
                $this->allDay[18][] = $date[1];
                $this->allDay[18][] = $valeur;
                break;

            case 19:
                $this->allDay[19][] = $date[1];
                $this->allDay[19][] = $valeur;
                break;

            case 20:
                $this->allDay[20][] = $date[1];
                $this->allDay[20][] = $valeur;
                break;

            case 21:
                $this->allDay[21][] = $date[1];
                $this->allDay[21][] = $valeur;
                break;

            case 22:
                $this->allDay[22][] = $date[1];
                $this->allDay[22][] = $valeur;
                break;

            case 23:
                $this->allDay[23][] = $date[1];
                $this->allDay[23][] = $valeur;
                break;

            case 24:
                $this->allDay[24][] = $date[1];
                $this->allDay[24][] = $valeur;
                break;

            case 25:
                $this->allDay[25][] = $date[1];
                $this->allDay[25][] = $valeur;
                break;

            case 26:
                $this->allDay[26][] = $date[1];
                $this->allDay[26][] = $valeur;
                break;

            case 27:
                $this->allDay[27][] = $date[1];
                $this->allDay[27][] = $valeur;
                break;

            case 28:
                $this->allDay[28][] = $date[1];
                $this->allDay[28][] = $valeur;
                break;

            case 29:
                $this->allDay[29][] = $date[1];
                $this->allDay[29][] = $valeur;
                break;

            case 30:
                $this->allDay[30][] = $date[1];
                $this->allDay[30][] = $valeur;
                break;

            case 31:
                $this->allDay[31][] = $date[1];
                $this->allDay[31][] = $valeur;
                break;
        }
    }


    public function populateMoy() : array {
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataJanvier));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataFevrier));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataMars));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataAvril));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataMai));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataJuin));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataJuillet));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataAout));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataSeptembre));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataOctobre));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataNovembre));
        $this->moyAllMonth[] = ($this->pushToArrayMoy($this->dataDecembre));

        return $this->moyAllMonth;
    }

    public function populateDayAsLabel($NumberDay) : string{
        $stringX = "";
        $stringY = "";
        $String = "";
        $i = 0;

        foreach ($this->allDay[$NumberDay] as $day){
            if ($i == sizeof($this->allDay[$NumberDay]) - 1 ){
                    $stringY = "y: " . $day . " }";
                    $String = $String . $stringX . $stringY;
                    // à l'echelle mois, mettre en parametre un jour pour choisir un jour en particulier et mettre To date pour aujourd'hui
            }
            else {
                if (is_string($day) == true) {
                    $stringX = "{x: '" . $day . "', ";
                }
                else {
                    $stringY="y: " . $day . " },";
                    $String = $String . $stringX . $stringY;
                }
            }
                $i++;
        }
        return $String;
    }

    /**
     * @return array
     */
    public function getAllDay(): array
    {
        return $this->allDay;
    }






}




// Je montre la moyenne sur 2h (8 captures pour 1 jours) et j'affiche 8 points (8h-10h-12h-14h-16h-18h-20h-22h) tous les semaines

// moyenne de 8h sur un mois (8 captures pour 1 mois) et j'affiche 8 points (8h -16h -24h)

// Je montre une capture toutes les 15 minutes (sur un jours)

// 96 data