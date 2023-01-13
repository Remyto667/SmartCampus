<?php


namespace App\Domain\Stat;
class Stat
{
    private $moyAllMonth = array();
    private $allDay = array();
    private $moyAllDay = array();
    private $allMonth = array();

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

    public function PushToArrayDateMonth2($date, $valeur): void            // On insere dans un tableau regroupant tous les jours d'un mois
    {                                                               // En premiere position, des tableaux sous la forme / 0:date , 1:valeur /

        //dd($date);
        //dd($valeur);

        if($date>0 and $date<13){

            $this->allMonth[$date][] = $valeur;

        }
    }

    public function PushToArrayDateDay($date, $valeur): void            // On insere dans un tableau regroupant tous les jours d'un mois
    {                                                               // En premiere position, des tableaux sous la forme / 0:date , 1:valeur /

        //dd($date);
        //dd($valeur);

        if($date[0]>0 and $date[0]<32){

            $arrayTempo[] =$date[1];
            $arrayTempo[]=$valeur;

            $this->allDay[$date[0]][] = $arrayTempo;

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

    public function PushToArrayMonthMoy($arrayMoy):float              // Calcule la moyenne de toutes les données lors d'un mois et
        // affichage sous forme de mois (avec la moyenne de chaque jour)
    {
        $cpp=0;

        //dd($arrayMoy);

        if($arrayMoy==0){
            $moy=0;
        }

        else{
            dd($arrayMoy);
            $cpp += $arrayMoy;
        }
        if(sizeof($arrayMoy)>1 ) {
            $moy = ($cpp / (sizeof($arrayMoy)/2));
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

    public function PopulateMonthMoy2() : array {


        for($i=1;$i<12;$i++){       // On tourne 31 fois

            $this->allMonth[$i][]=0;      // Et on insere un zero dans le cas ou il n'y aurait pas de données ce jour ci
            //(facilite le calcul de moyenne)

            dd($this->allMonth);
            $this->moyAllMonth[]=($this->PushToArrayMonthMoy($this->allMonth[$i]));
        }

        return $this->moyAllDay;            // Renvoie un tableau regroupant les moyennes de chaques jours dans un mois
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


        foreach($this->allDay[$NumberDay] as $day){

            $stringX= ";
            $stringY=";
            $String="{x: '".$day[0]."',y: ".$day[1]." }";

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