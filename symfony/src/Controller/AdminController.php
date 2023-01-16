<?php

namespace App\Controller;

use App\Domain\Alert;
use App\Domain\Query\ConseilAlerteQuery;
use App\Domain\Query\ConseilAlerteHandler;
use App\Domain\Query\DonneesCapteursHandler;
use App\Domain\Query\DonneesCapteursQuery;
use App\Entity\Room;
use App\Entity\Sensor;
use App\Entity\System;
use App\Form\RoomType;
use App\Form\SensorType;
use App\Form\SystemType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\All;
use App\Domain\Stat;

class AdminController extends AbstractController
{
    #[Route('/', name: 'menu')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_accueil');
    }
    #[Route('/accueil', name: 'app_accueil')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/guide', name: 'admin_guide')]
    public function guide(): Response
    {
        return $this->render('admin/guide.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/profil', name: 'profil_admin')]
    public function connectionAdmin(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        $repository = $entityManager->getRepository('App\Entity\System');
        $allSystem = $repository->findAll();

        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $allSensor = $repository->findAll();

        return $this->render('admin/profil.html.twig', [
            'countRoom' => sizeof($allRoom) - 1,
            'countSystem' => sizeof($allSystem),
            'CountSensor' => sizeof($allSensor),
        ]);
    }

    #[Route('/inventaire', name: 'inventaire')]
    public function inventory(): Response
    {
        return $this->render('admin/inventaire.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/inventaire/lister_salles/{ok?1}', name: 'listerSalles')]
    public function listRooms(ManagerRegistry $doctrine, ?int $ok, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        $noData = array();
        foreach ($allRoom as $room) {
            $donnees = $handler->handle(new DonneesCapteursQuery($room, $doctrine));
            $temp = $donnees["T"]->valeur;
            $hum = $donnees["H"]->valeur;
            $co2 = $donnees["C"]->valeur;
            if ($temp == "NULL" or $hum == "NULL" or $co2 == "NULL") {
                $noData[$room->getId()] = 1;
            } else {
                $noData[$room->getId()] = 0;
            }
        }

        return $this->render('admin/lister_salles.html.twig', [
            'ok' => $ok,
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloorClassroom(),
            'noData' => $noData,
        ]);
    }

    #[Route('/inventaire/lister_systemes', name: 'listerSystemes')]
    public function listSystems(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $systems = $repository->findAll();
        $repository2 = $entityManager->getRepository('App\Entity\Sensor');
        $nbSensor = $repository2->countSensorOfSystem();

        return $this->render('admin/lister_systemes.html.twig', [
            'systems' => $systems,
            'nbsensor' => $nbSensor,
        ]);
    }

    #[Route('/inventaire/lister_capteurs', name: 'listerCapteurs')]
    public function listSensor(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $list = $doctrine->getRepository(Sensor::class)->listOfAllSensor();
        return $this->render('admin/lister_capteurs.html.twig', [
            'controller_name' => 'Liste des Capteurs',
            'allSensor' => $list,
        ]);
    }

    #[Route('/inventaire/ajouter_capteur', name: 'ajouterCapteur')]
    public function addSensor(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sensor = new Sensor();
        $form = $this->createForm(SensorType::class, $sensor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $entityManager->persist($sensor);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerCapteurs', []));
        }
        return $this->render('admin/ajouter_capteur.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inventaire/ajouter_salle', name: 'ajouter_salle')]
    public function addRoom(Request $request, ManagerRegistry $doctrine): Response
    {
        $room = new Room();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $entityManager->persist($room);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerSalles', []));
        }

        return $this->render('admin/ajouter_salle.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    #[Route('/inventaire/ajouter_systeme', name: 'ajouterSystemes')]
    public function addSystem(Request $request, EntityManagerInterface $entityManager): Response
    {
        $system = new System();

        $form = $this->createForm(SystemType::class, $system);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ){
            $entityManager->persist($system);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerSystemes', []));
        }

        return $this->render('admin/ajouter_systeme.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/inventaire/modifier_systeme/{id?}', name: 'modifierSystemes')]
    public function updateSystem(Request $request, ?int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $system = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(SystemType::class, $system);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($system);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerSystemes', []));
        }

        return $this->render('admin/ajouter_systeme.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inventaire/modifier_salle/{id?}', name: 'modifierSalles')]
    public function update_room(Request $request, ?int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->find($id);

        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($room);
            $entityManager->flush();
            return $this->redirectToRoute('listerSalles');
        }

        return $this->render('admin/ajouter_salle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inventaire/modifier_capteur/{id?}', name: 'modifierCapteurs')]
    public function updateSensor(Request $request, ?int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager =$doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $sensor = $repository->find($id);
        $form = $this->createForm(SensorType::class, $sensor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ){
            $entityManager->persist($sensor);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerCapteurs', []));
        }

        return $this->render('admin/ajouter_capteur.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inventaire/supprimer_capteur/{id?}', name: 'supprimerCapteur')]
    public function deleteSensor(Request $request, ?int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $sensor = $repository->find($id);
        $entityManager->remove($sensor);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('listerCapteurs', []));


    }
    #[Route('/inventaire/supprimer_systeme/{id?}', name: 'supprimerSysteme')]
    public function deleteSystem(Request $request, ?int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $system = $repository->find($id);
        $entityManager->remove($system);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('listerSystemes'));
    }

    #[Route('/inventaire/supprimer_salle/{id?}', name: 'supprimerSalle')]
    public function deleteRoom(Request $request, ?int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->find($id);

        return $this->redirect($this->generateUrl('listerSalles', ['ok' => $repository->remove($room, true)]));
    }

    #[Route('admin/selection_salle', name: 'selectionSalle')]
    public function selectRoom(ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach ($allRoom as $room)
        {
            $handler->handle(new DonneesCapteursQuery($room, $doctrine));
        }

        return $this->render('admin/selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
        ]);

    }
    #[Route('/admin/donnees_salle_admin/{room?}', name: 'donneesSalleAdmin')]
    public function dataRoomAdmin(?Room $room, ManagerRegistry $doctrine, DonneesCapteursHandler $handler, ConseilAlerteHandler $handler2): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        //pour mettre les alertes
        foreach ($allRoom as $rooms)
        {
            $handler->handle(new DonneesCapteursQuery($rooms, $doctrine));
        }

        $donnees=$handler->handle(new DonneesCapteursQuery($room, $doctrine));

        $conseils=$handler2->handle(new ConseilAlerteQuery($room, $doctrine));


        return $this->render('admin/donnees_salle_admin.html.twig', [
            'conseil' => $conseils[0],
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
            'room' => $room,
            'temp' => $donnees["T"]->valeur,
            'hum' => $donnees["H"]->valeur,
            'co2' => $donnees["C"]->valeur,
            'dateT' => $donnees["T"]->dateCapture,
            'dateH' => $donnees["H"]->dateCapture,
            'dateC' => $donnees["C"]->dateCapture,
        ]);    }
/*
    #[Route('/admin/alerte/{roomId?}/{id?}', name: 'alerteAdmin')]
    public function alerte_salle_admin(?int $roomId, ?int $id, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response{

        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->findOneBy(['id' => $roomId]);

       $donnees=$handler->handle(new DonneesCapteursQuery($room, $doctrine));
        //récupération dans l'api open Weather
       //récupération de la température de la rochelle
        $city = 'La Rochelle';

        // Création de l'instance HttpClient
        $client = HttpClient::create();

        // Envoi de la requête à l'API OpenWeather
        $response = $client->request('GET',https://api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key});

        // Récupérez la réponse sous forme de tableau PHP
        $data = json_decode($response->getBody(), true);

        // Récupérez la température à partir du tableau de données
        $temperature = $data['main']['temp'];

        return $this->render('admin/alerte.html.twig', [
            'temperature' => $temperature,
            'id' => $id,
            'room' => $room->getName(),
            'temp' => $donnees["T"]->valeur,
            'hum' => $donnees["H"]->valeur,
            'co2' => $donnees["C"]->valeur,
        ]);    }

*/
    #[Route('admin/suivi/selection_salle', name: 'suivi_selectionSalle')]
    public function selectRoomReview(Request $request, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach ($allRoom as $room)
        {
            $handler->handle(new DonneesCapteursQuery($room, $doctrine));
        }

        return $this->render('admin/suivi_selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
        ]);

    }

    #[Route('/admin/suivi/graphique/{room?}', name: 'graph_admin')]         // Donnée actuelle
    public function graphique_admin(?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $statTemp= new Stat\Stat();
        $statHum= new Stat\Stat();
        $statCo2= new Stat\Stat();
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach ($allRoom as $rooms)
        {
            $handler->handle(new DonneesCapteursQuery($rooms, $doctrine));
        }

        $donnees=$handler->handleGraph(new DonneesCapteursQuery($room, $doctrine));             // Récupération de toutes les données de l'API


        foreach($donnees["T"] as $temp){

            if($temp->localisation == $room->getName()){

                //dd(gettype($temp->dateCapture));
                $statTemp->PushToArrayDateMonth($statTemp->transformMonth($temp->dateCapture),doubleval($temp->valeur));        // On classe les données en fonction de leur mois
                $statTemp->PushToArrayDateDay($statTemp->transformDay($temp->dateCapture),doubleval($temp->valeur));
            }
        }

        $dataDayTemp=$statTemp->PopulateDayAsLabel(date("j")); //
        $moyYearTemp=json_encode($statTemp->PopulateMonthMoy());                 // On calcule la moyenne de chaque mois et on structure en tableau sur une année
        $moyMonthTemp=json_encode($statTemp->PopulateDayMoy());         // On calcule la moyenne de chaque jours et on structure en tableau sur un mois

        foreach($donnees["H"] as $hum){

            if($hum->localisation == $room->getName()) {
                $statHum->PushToArrayDateMonth($statHum->transformMonth($hum->dateCapture), doubleval($hum->valeur));        // Hum
                $statHum->PushToArrayDateDay(($statHum->transformDay($hum->dateCapture)), doubleval($hum->valeur));
            }

        }


        $dataDayHum=$statHum->PopulateDayAsLabel(date("j"));
        $moyYearHum=json_encode($statHum->PopulateMonthMoy());       // Hum
        $moyMonthHum=json_encode($statHum->PopulateDayMoy());


        foreach($donnees["C"] as $co2){

            if($co2->localisation == $room->getName()) {
                $statCo2->PushToArrayDateMonth($statCo2->transformMonth($co2->dateCapture), doubleval($co2->valeur));        // Co2
                $statCo2->PushToArrayDateDay(($statCo2->transformDay($co2->dateCapture)), doubleval($co2->valeur));
            }

        }

        $dataDayCo2=$statCo2->PopulateDayAsLabel(date("j"));
        $moyYearCo2=json_encode($statCo2->PopulateMonthMoy());       // Co2
        $moyMonthCo2=json_encode($statCo2->PopulateDayMoy());


        return $this->render('admin/graphique.html.twig', [
            'room' => $room,
            'moyYearTemp' =>$moyYearTemp,
            'moyYearHum' =>$moyYearHum,
            'moyYearCo2' =>$moyYearCo2,
            'moyMonthTemp'=>$moyMonthTemp,
            'moyMonthHum' =>$moyMonthHum,
            'moyMonthCo2' =>$moyMonthCo2,
            'dataDayTemp'=>$dataDayTemp,
            'dataDayHum' =>$dataDayHum,
            'dataDayCo2' =>$dataDayCo2,
            'year' =>$year=date("Y"),




            //'data'=>$dataDay,
        ]);
    }

    #[Route('/admin/suivi/graphique/{room?}/{annee?}', name: 'graph_annee_admin')]               // Choix annee
    public function graphique_annne_admin(int $annee,?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $statTemp= new Stat\Stat();
        $statHum= new Stat\Stat();
        $statCo2= new Stat\Stat();

        $date1= date('Y-m-d',mktime(0,0,0,01,01,$annee));
        $date2= date('Y-m-d',mktime(0,0,0,01,01,$annee+1));


        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        /*      -------  Recupérations données    ---------    */

        foreach($allRoom as $rooms)
        {
            $handler->handle(new DonneesCapteursQuery($rooms, $doctrine));
        }

        $donnees=$handler->handleInterval(new DonneesCapteursQuery($room, $doctrine),$date1,$date2);             // Récupération de toutes les données de l'API

        /*      -------  Recupérations Temperature    ---------    */


            foreach ($donnees["T"] as $temp) {

                if($temp['localisation'] == $room->getName()) {

                    $statTemp->PushToArrayDateMonth($statTemp->transformMonth($temp['dateCapture']), doubleval($temp['valeur']));  // On classe les données en fonction de leur mois
                }
            }

            $moyYearTemp = json_encode($statTemp->PopulateMonthMoy());                 // On calcule la moyenne de chaque mois et on structure en tableau sur une année
            //dd($moyYearTemp =json_encode($statTemp->PopulateMonthMoy2()));


            /*      -------  Recupérations Humidite    ---------    */

        foreach ($donnees["H"] as $hum) {

            if($hum['localisation'] == $room->getName()) {
                $statHum->PushToArrayDateMonth($statHum->transformMonth($hum['dateCapture']), doubleval($hum['valeur']));        // Hum
            }
        }


        $moyYearHum = json_encode($statHum->PopulateMonthMoy());       // Hum



            /*      -------  Recupérations Co2    ---------    */

        foreach ($donnees["C"] as $co2) {

            if($co2['localisation'] == $room->getName()) {
                $statCo2->PushToArrayDateMonth($statCo2->transformMonth($co2['dateCapture']), doubleval($co2['valeur']));        // Co2
            }
        }

        $moyYearCo2 = json_encode($statCo2->PopulateMonthMoy());       // Co2


        return $this->render('admin/graphique_year.html.twig', [
            'room' => $room,
            'moyYearTemp' =>$moyYearTemp,
            'moyYearHum' =>$moyYearHum,
            'moyYearCo2' =>$moyYearCo2,
            'year' =>$year=date("Y"),
            'month' => 1,
            'annee_choisi' => $annee,

        ]);
    }




    #[Route('/admin/suivi/graphique/{room?}/{annee?}/{month?}', name: 'graph_annee_month_admin')]
    public function graphique_annne_month_admin(int $month,int $annee,?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response      // Choix mois
    {
        $statTemp= new Stat\Stat();
        $statHum= new Stat\Stat();
        $statCo2= new Stat\Stat();

        $date1= date('Y-m-d',mktime(0,0,0,$month,01,$annee));
        $date2= date('Y-m-d',mktime(0,0,0,$month+1,01,$annee));

        //$date1;

        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        /*      -------  Recupérations données    ---------    */

        foreach($allRoom as $rooms)
        {
            $handler->handle(new DonneesCapteursQuery($rooms, $doctrine));
        }

        $donnees=$handler->handleInterval(new DonneesCapteursQuery($room, $doctrine),$date1,$date2);             // Récupération de toutes les données de l'API

        /*      -------  Recupérations Temperature    --------- */


        foreach ($donnees["T"] as $temp) {

            if($temp['localisation'] == $room->getName()) {
                $statTemp->PushToArrayDateDay($statTemp->transformDay($temp['dateCapture']), doubleval($temp['valeur']));       // Temp
                $statTemp->PushToArrayDateMonth($statTemp->transformMonth($temp['dateCapture']), doubleval($temp['valeur']));

            }
        }

        $moyMonthTemp=json_encode($statTemp->PopulateDayMoy()); // On calcule la moyenne de chaque jours et on structure en tableau sur un mois
        $moyYearTemp = json_encode($statTemp->PopulateMonthMoy());

        /*      -------  Recupérations Humidite    ---------    */

        foreach ($donnees["H"] as $hum) {

            if($hum['localisation'] == $room->getName()) {
                $statHum->PushToArrayDateDay($statHum->transformDay($hum['dateCapture']), doubleval($hum['valeur']));       // Hum
                $statHum->PushToArrayDateMonth($statHum->transformMonth($hum['dateCapture']), doubleval($hum['valeur']));
            }

        }

        $moyMonthHum=json_encode($statHum->PopulateDayMoy());// Hum
        $moyYearHum = json_encode($statHum->PopulateMonthMoy());

        /*      -------  Recupérations Co2    ---------    */

        foreach ($donnees["C"] as $co2) {

            if($co2['localisation'] == $room->getName()) {
                $statCo2->PushToArrayDateDay($statCo2->transformDay($co2['dateCapture']), doubleval($co2['valeur']));       // Co2
                $statCo2->PushToArrayDateMonth($statCo2->transformMonth($co2['dateCapture']), doubleval($co2['valeur']));

            }
        }


        $moyMonthCo2=json_encode($statCo2->PopulateDayMoy());   // Co2
        $moyYearCo2 = json_encode($statCo2->PopulateMonthMoy());

        $this->get('session')->start();
        $this->get('session')->set('moyYearTemp', $moyYearTemp);
        $this->get('session')->set('moyYearHum', $moyYearHum);              // Utile pour récupérer la moyenne de l'année dans la route lié aux jours
        $this->get('session')->set('moyYearCo2', $moyYearCo2);

        return $this->render('admin/graphique_year_month.html.twig', [
            'room' => $room,
            'moyMonthTemp'=>$moyMonthTemp,
            'moyMonthHum' =>$moyMonthHum,
            'moyMonthCo2' =>$moyMonthCo2,
            'moyYearTemp' =>$moyYearTemp,
            'moyYearHum' =>$moyYearHum,
            'moyYearCo2' =>$moyYearCo2,
            'year' =>$year=date("Y"),
            'annee_choisi' => $annee,
            'mois_choisi' => $month,
             'nb_jours'=>date('t', strtotime($annee . '-' . $month . '-01')),
            'nb_jours_valide'=>date('t', strtotime($annee . '-' . $month . '-01'))-date("j"),
            'mois'=>date("m"),


        ]);
    }

    #[Route('/admin/suivi/graphique/{room?}/{annee?}/{month?}/{day?}', name: 'graph_annee_month_day_admin')]
    public function graphique_annne_month_day_admin(int $day,int $month,int $annee,?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response      // Choix mois
    {
        $statTemp= new Stat\Stat();
        $statHum= new Stat\Stat();
        $statCo2= new Stat\Stat();

        $date1= date('Y-m-d',mktime(0,0,0,$month,$day,$annee));
        $date2= date('Y-m-d',mktime(0,0,0,$month,$day+1,$annee));

        //$date1;

        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        /*      -------  Recupérations données    ---------    */

        foreach($allRoom as $rooms)
        {
            $handler->handle(new DonneesCapteursQuery($rooms, $doctrine));
        }

        $donnees=$handler->handleInterval(new DonneesCapteursQuery($room, $doctrine),$date1,$date2);             // Récupération de toutes les données de l'API

        /*      -------  Recupérations Temperature    --------- */


        foreach ($donnees["T"] as $temp) {

            if($temp['localisation'] == $room->getName()) {
                $statTemp->PushToArrayDateDay($statTemp->transformDay($temp['dateCapture']), doubleval($temp['valeur']));
                $statTemp->PushToArrayDateMonth($statTemp->transformMonth($temp['dateCapture']), doubleval($temp['valeur']));
                // On sort les captures de chaque jours et on affiche
            }
        }

        $dataDayTemp=$statTemp->PopulateDayAsLabel($day);  // Temp
        $moyMonthTemp=json_encode($statTemp->PopulateDayMoy());



        /*      -------  Recupérations Humidite    ---------    */

        foreach ($donnees["H"] as $hum) {

            if($hum['localisation'] == $room->getName()) {
                $statHum->PushToArrayDateDay($statHum->transformDay($hum['dateCapture']), doubleval($hum['valeur']));
                $statHum->PushToArrayDateMonth($statHum->transformMonth($hum['dateCapture']), doubleval($hum['valeur']));
            }

        }
        $dataDayHum=$statHum->PopulateDayAsLabel($day);      // Hum
        $moyMonthHum=json_encode($statHum->PopulateDayMoy());


        /*      -------  Recupérations Co2    ---------    */

        foreach ($donnees["C"] as $co2) {

            if($co2['localisation'] == $room->getName()) {
                $statCo2->PushToArrayDateDay($statCo2->transformDay($co2['dateCapture']), doubleval($co2['valeur']));
                $statCo2->PushToArrayDateMonth($statCo2->transformMonth($co2['dateCapture']), doubleval($co2['valeur']));
            }
        }

        $dataDayCo2=$statCo2->PopulateDayAsLabel($day);       // Co2
        $moyMonthCo2=json_encode($statCo2->PopulateDayMoy());

        return $this->render('admin/graphique_year_month_day.html.twig', [
            'room' => $room,
            'year' =>date("Y"),
            'dataDayTemp'=>$dataDayTemp,
            'dataDayHum' =>$dataDayHum,
            'dataDayCo2' =>$dataDayCo2,
            'moyMonthTemp'=>$moyMonthTemp,
            'moyMonthHum' =>$moyMonthHum,
            'moyMonthCo2' =>$moyMonthCo2,
            'moyYearTemp' =>$this->get('session')->get('moyYearTemp'),
            'moyYearHum' =>$this->get('session')->get('moyYearHum'),
            'moyYearCo2' =>$this->get('session')->get('moyYearCo2'),
            'annee_choisi' => $annee,
            'mois_choisi' => $month,
            'nb_jours'=>date('t', strtotime($annee . '-' . $month . '-01')),
            'nb_jours_valide'=>date('t', strtotime($annee . '-' . $month . '-01'))-date("j"),
            'mois'=>date("m"),
        ]);
    }







    #[Route('admin/alerte_selection', name: 'alerte_selection')]
    public function alerte_selection_salle(ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();
        $nbAlert = array();

        //on récupères les deux dates
        $month = date('m');
        $year=date('y');
        $date2 = '20'.$year.'-'.$month.'-'.date('j');
        if($month==01){
            $month=12;
            $year--;
        }
        elseif ($month < 10){
            $temp=$month-1;
            $month= '0' . $temp;
        }
        else{
            $month--;
        }
        $date1 = '20'.$year.'-'.$month.'-'.date('j');
        foreach($allRoom as $room)
        {
            /* appel alerte_vision */
            $nbAlert[$room->getId()] = $this->alerte_count($room, $doctrine, $handler,$date1,$date2);

        }
        return $this->render('admin/alerte_selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
            'nbAlert' =>$nbAlert,
        ]);
    }

    /**
     * @return array<mixed>
     */
    public function alerte_count(?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler,String $date1, String $date2): array
    {
        $nbAlert = array();
        if($room->getName()!="Stock"){
            $nbAlert= $handler->handleNbAlert(new DonneesCapteursQuery($room, $doctrine),$date1,$date2);
        }
        return $nbAlert;
    }

    #[Route('/admin/alerte_vision/{room?}', name: 'alerte_vision_admin')]
    public function alerte_visionV2(?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        //on récupères les deux dates
        $month = date('m');
        $year = date('y');
        $date2 = '20'.$year.'-'.$month.'-'.date('j');
        if($month == 01){
            $month = 12;
            $year --;
        }
        elseif ( $month < 10){
            $temp=$month-1;
            $month= '0' . $temp;
        }
        else{
            $month --;
        }
        $date1 = '20' . $year . '-' . $month . '-' . date('j');
        $nbAlert = array();
        if($room->getName() != "Stock"){
            //initialize
            $handler->handle(new DonneesCapteursQuery($room, $doctrine));
            $nbAlert=$this->alerte_count($room, $doctrine, $handler,$date1,$date2);
        }
        return $this->render('admin/alerteStat.html.twig', [
            'room' => $room,
            'nbAlert' =>$nbAlert,
        ]);
    }

}


