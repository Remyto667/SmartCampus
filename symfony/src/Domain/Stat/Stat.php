<?php

namespace App\Domain\Stat;
class Stat
{
    /**
     * @var array<float>
     */
    private $moyAllMonth = array();

    /**
     * @var array<array<array<mixed>>>
     */
    private $allDay = array();

    /**
     * @var array<float>
     */
    private $moyAllDay = array();

    /**
     * @var array<array<float>>
     */
    private $allMonth = array();
    /**
     * @var array<float>
     */
    private $dataJanvier = array();
    /**
     * @var array<float>
     */
    private $dataFevrier = array();
    /**
     * @var array<float>
     */
    private $dataMars = array();
    /**
     * @var array<float>
     */
    private $dataAvril = array();
    /**
     * @var array<float>
     */
    private $dataMai = array();
    /**
     * @var array<float>
     */
    private $dataJuin = array();
    /**
     * @var array<float>
     */
    private $dataJuillet = array();
    /**
     * @var array<float>
     */
    private $dataAout = array();
    /**
     * @var array<float>
     */
    private $dataSeptembre = array();
    /**
     * @var array<float>
     */
    private $dataOctobre = array();
    /**
     * @var array<float>
     */
    private $dataNovembre = array();
    /**
     * @var array<float>
     */
    private $dataDecembre = array();


    /**
     * @return string|null
     */

    public function transformMonth($dateCapture): ?string           // A partir d'une date donnée, on récupere le mois
    {
        $arrayDateCapture = explode(" ", $dateCapture);

        $arrayDate =  explode('-', $arrayDateCapture[0]);

        return $arrayDate[1];
    }

    /**
     * @return array<string>|null
     */
    public function transformDay($dateCapture): ?array          // A partir d'une date donnée, on récupere le jour et l'heure
    {
        $arrayResult=array();
        $arrayDateCapture = explode(" ", $dateCapture);
        $arrayDate = explode('-', $arrayDateCapture[0]);

        $arrayResult[] = $arrayDate[2];
        $arrayResult[] = $arrayDateCapture[1];

        return $arrayResult;
    }


    public function PushToArrayDateMonth(int $date, float $valeur): void      // On insere dans un tableau les données du mois associé
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

    public function PushToArrayDateMonth2($date, $valeur): void            // On insere dans un tableau regroupant tous les jours d'un mois
    {                                                               // En premiere position, des tableaux sous la forme / 0:date , 1:valeur /
// Optimisation debut
        //dd($date);
        //dd($valeur);

        if($date>0 and $date<13){

            $this->allMonth[$date][] = $valeur;

        }
    }

    /**
     * @param array<string> $date
     * @param float $valeur
     * @return void
     */
    public function PushToArrayDateDay(array $date, float $valeur): void            // On insere dans un tableau regroupant tous les jours d'un mois
    {                                                               // En premiere position, des tableaux sous la forme / 0:date , 1:valeur /

        //dd($date);
        //dd($valeur);

        if($date[0]>0 and $date[0]<32){

            $arrayTempo[] =$date[1];
            $arrayTempo[]=$valeur;

            $this->allDay[(int)$date[0]][] = $arrayTempo;

        }
    }

    /**
     * @param array<float> $arrayMoy
     * @return float
     */

    public function PushToArrayYearMoy(array $arrayMoy):float     // Calcule la moyenne de toutes les données lors d'un mois et affichage
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

        return round($moy,1);

    }

    /**
     * @param array<float> $arrayMoy
     * @return float
     */

    public function PushToArrayMonthMoy(array $arrayMoy):float              // Calcule la moyenne de toutes les données lors d'un mois et
                                                                        // affichage sous forme de mois (avec la moyenne de chaque jour)
    {// Optimisation debut
        $cpp=0;


        if($arrayMoy==0){
            $moy=0;
        }

        else{
            foreach($arrayMoy as $data){
                $cpp += $data;
            }

            if(sizeof($arrayMoy)>1 ) {
                $moy = ($cpp / (sizeof($arrayMoy)/2));
            }
            else{
                $moy=0;
            }

        }

        return $moy;

    }

    public function PushToArrayDayMoy(array $arrayMoy):float              // Calcule la moyenne de toutes les données lors d'un mois et
                                                                    // affichage sous forme de mois (avec la moyenne de chaque jour)
    {

        $cpp=0;

        if($arrayMoy[0]==0){            // Si la premiere donnée est un 0 alors le tableau est vide
            $moy=0;
        }

        else {
            //dd($arrayMoy);

            for($i=0;$i<sizeof($arrayMoy)-2;$i++){          // Sinon il ya des donneés, on parcourt la taille du tableau -2
                                                            // a cause du 0 ajouté a la fin
                $cpp +=$arrayMoy[$i][1];

            }


            if (sizeof($arrayMoy) > 1) {

                //dd($arrayMoy[0]);

                $moy = ($cpp / (sizeof($arrayMoy)-2));
            } else {
                $moy = 0;
            }
        }


        return round($moy,1);

    }


    /**
     * @return array<float>
     */

    public function PopulateMonthMoy() : array { // Applique dans un tableau le calcul de moyenne sur toutes les données de chaque mois

        //dd($this->dataJanvier);

        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataJanvier));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataFevrier));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataMars));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataAvril));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataMai));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataJuin));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataJuillet));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataAout));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataSeptembre));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataOctobre));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataNovembre));
        $this->moyAllMonth[]=($this->PushToArrayYearMoy($this->dataDecembre));

        return $this->moyAllMonth;          // Renvoie un tableau regroupant les moyennes de chaques mois dans l'année

    }

    public function PopulateMonthMoy2() : array {       // Optimisation debut


        for($i=1;$i<12;$i++){       // On tourne 31 fois

            $this->allMonth[$i][]=0;      // Et on insere un zero dans le cas ou il n'y aurait pas de données ce jour ci
            //(facilite le calcul de moyenne)

            //dd($this->allMonth);
            $this->moyAllMonth[]=($this->PushToArrayMonthMoy($this->allMonth[$i]));
        }

        return $this->moyAllDay;            // Renvoie un tableau regroupant les moyennes de chaques jours dans un mois
    }

    /**
     * @return array[]
     */

    public function PopulateDayMoy() : array {

        //dd($this->allDay);

        for($i=1;$i<32;$i++){       // On tourne 31 fois

            $this->allDay[$i][]=0;      // Et on insere un zero dans le cas ou il n'y aurait pas de données ce jour ci
                                        // (facilite le calcul de moyenne)

            $this->moyAllDay[]=($this->PushToArrayDayMoy($this->allDay[$i]));
        }

        return $this->moyAllDay;            // Renvoie un tableau regroupant les moyennes de chaques jours dans un mois
    }

    /**
     * @param int $NumberDay
     * @return array<array<string,float>>
     */


    public function PopulateDayAsLabel(int $NumberDay) : array{             // Creation d'un tableau composé de string pour les labels du graphique

        $this->allDay[$NumberDay][]=0;          // On insere un zero dans le cas ou il n'y aurait pas de données ce aujourd'hui
        $String= array();

        if ($this->allDay[$NumberDay][0]==0){       // Si la premiere valeur du tableau vaut 0 == pas de donnée (sinon il serait en derniere position)

            $String[] = "{x: '" . "Pas de donnée" . "',y: " . 0 . " }";
        }
        else {

            $day=$this->allDay[$NumberDay];

            for($i=0;$i<sizeof($day)-2;$i++){       // Sinon il a des données et on extrait sous la forme d'un tableau JS


                $String[] = "{x: '" . $day[$i][0] . "',y: " . $day[$i][1] . " }";

            }

        }
        return $String  ;

        //"{x: '".$day."', y: ".$day[$i+1]." }"

    }

    /**
     * @return array<array<array<mixed>>>
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