<?php


namespace App\Domain\Stat;
class Stat
{
    private $moyAllMonth = array();
    private $allDay = array();
    private $moyAllDay = array();
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



    public function transformMonth($dateCapture): ?string           // A partir d'une date donnée, on récupere le mois
    {
        $arrayDateCapture = explode(" ", $dateCapture);

        $arrayDate =  explode('-', $arrayDateCapture[0]);

        return $arrayDate[1];
    }

    public function transformDay($dateCapture): ?array          // A partir d'une date donnée, on récupere le jour et l'heure
    {
        $arrayDateCapture = explode(" ", $dateCapture);

        $arrayDate =  explode('-', $arrayDateCapture[0]);

        $arrayResult[]=$arrayDate[2];
        $arrayResult[]=$arrayDateCapture[1];

        return $arrayResult;

    }



    public function PushToArrayDateMonth($date, $valeur): void      // On insere dans un tableau les données du mois associé
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

    public function PushToArrayDateDay($date, $valeur): void            // On insere dans un tableau regroupant tous les jours d'un mois
    {                                                               // En premiere position, des tableaux sous la forme / 0:date , 1:valeur /

        //dd($date);
        //dd($valeur);

        switch($date[0]){

            case 1: $arrayTempo[] =$date[1];
                    $arrayTempo[]=$valeur;
                $this->allDay[1][] = $arrayTempo;

                break;

            case 2:
                $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[2][] = $arrayTempo;
                break;

            case 3: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[3][] = $arrayTempo;
                break;

            case 4: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[4][] = $arrayTempo;

                break;

            case 5: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[5][] = $arrayTempo;
                break;

            case 6:$arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[6][] = $arrayTempo;
                break;

            case 7: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[7][] = $arrayTempo;
                break;

            case 8: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[8][] = $arrayTempo;
                break;

            case 9: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[9][] = $arrayTempo;
                break;

            case 10: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[10][] = $arrayTempo;
                break;

            case 11: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[11][] = $arrayTempo;
                break;

            case 12: $arrayTemp[] =$date[1];
                $arrayTemp[]=$valeur;
                $this->allDay[12][] = $arrayTemp;
                break;

            case 13: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[13][] = $arrayTempo;
                break;

            case 14: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[14][] = $arrayTempo;
                break;

            case 15: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[15][] = $arrayTempo;

                break;

            case 16: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[16][] = $arrayTempo;
                break;

            case 17: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[17][] = $arrayTempo;
                break;

            case 18: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[18][] = $arrayTempo;
                break;

            case 19: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[19][] = $arrayTempo;
                break;

            case 20: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[20][] = $arrayTempo;
                break;

            case 21: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[21][] = $arrayTempo;
                break;

            case 22: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[22][] = $arrayTempo;
                break;

            case 23: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[23][] = $arrayTempo;
                break;

            case 24:$arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[24][] = $arrayTempo;
                break;

            case 25: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[25][] = $arrayTempo;
                break;

            case 26: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[26][] = $arrayTempo;
                break;

            case 27:  $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[27][] = $arrayTempo;
                break;

            case 28: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[28][] = $arrayTempo;
                break;

            case 29: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[29][] = $arrayTempo;
                break;

            case 30: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[30][] = $arrayTempo;
                break;

            case 31: $arrayTempo[] =$date[1];
                $arrayTempo[]=$valeur;
                $this->allDay[31][] = $arrayTempo;
                break;

        }

    }

    public function PushToArrayMoy($arrayMoy):float     // Calcule la moyenne de toutes les données lors d'un mois et affichage
                                                        // sous forme d'année
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

    public function PushToArrayDayMoy($arrayMoy):float              // Calcule la moyenne de toutes les données lors d'un mois et
                                                                    // affichage sous forme de mois (avec la moyenne de chaque jour)
    {
        $cpp=0;
        if($arrayMoy[0]==0){
            $moy=0;
        }
        else{
            $cpp += $arrayMoy[0][1];
        }
            if(sizeof($arrayMoy)>1 ) {
                $moy = ($cpp / (sizeof($arrayMoy[0])/2));
            }
            else{
                $moy=0;
            }


        return $moy;

    }


    public function PopulateMonthMoy() : array { // Applique dans un tableau le calcul de moyenne sur toutes les données de chaque mois

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


        return $this->moyAllMonth;          // Renvoie un tableau regroupant les moyennes de chaques mois dans l'année

    }

    public function PopulateDayMoy() : array {


        for($i=1;$i<31;$i++){       // On tourne 31 fois

            $this->allDay[$i][]=0;      // Et on insere un zero dans le cas ou il n'y aurait pas de données ce jour ci
                                        //(facilite le calcul de moyenne)

            $this->moyAllDay[]=($this->PushToArrayDayMoy($this->allDay[$i]));
        }

        return $this->moyAllDay;            // Renvoie un tableau regroupant les moyennes de chaques jours dans un mois
    }


    public function PopulateDayAsLabel($NumberDay) : string{

        //dd($this->allDay[$NumberDay]);

        $stringX="";
        $stringY="";
        $String="";
        $i=0;

        foreach($this->allDay[$NumberDay] as $day){


            if($i==sizeof($this->allDay[$NumberDay])-1 ){

                    $stringY="y: ".$day[1]." }";
                    $String=$String.$stringX.$stringY;
                    // à l'echelle mois, mettre en parametre un jour pour choisir un jour en particulier et mettre To date pour aujourd'hui

            }


            else{
                $stringX="{x: '".$day[0]."', ";
                $stringY="y: ".$day[1]." },";
                $String=$String.$stringX.$stringY;

            }
                $i++;

        }
        return $String;

        //"{x: '".$day."', y: ".$day[$i+1]." }"

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