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
    public function connexion_admin(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        $repository = $entityManager->getRepository('App\Entity\Room');
        $allSystem = $repository->findAll();

        $repository = $entityManager->getRepository('App\Entity\Room');
        $allSensor = $repository->findAll();

        return $this->render('admin/profil.html.twig', [
            'countRoom' => sizeof($allRoom)-1,
            'countSystem' => sizeof($allSystem),
            'CountSensor' => sizeof($allSensor),
        ]);
    }

    #[Route('/inventaire', name: 'inventaire')]
    public function inventaire(): Response
    {
        return $this->render('admin/inventaire.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/inventaire/lister_salles/{ok?1}', name: 'listerSalles')]
    public function lister_salles(ManagerRegistry $doctrine, ?int $ok, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        $noData = array();
        foreach($allRoom as $room) {
            $donnees = $handler->handle(new DonneesCapteursQuery($room, $doctrine));
            $temp = $donnees["T"]->valeur;
            $hum = $donnees["H"]->valeur;
            $co2 = $donnees["C"]->valeur;
            if ($temp =="NULL" or $hum =="NULL" or $co2 =="NULL") {
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
    public function lister_systemes(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $systems = $repository->findAll();
        $repository2 = $entityManager->getRepository('App\Entity\Sensor');
        $nbSensor = $repository2->countSensorOfSystem();

        return $this->render('admin/lister_systemes.html.twig', [
            'systems'=>$systems,
            'nbsensor'=>$nbSensor,
        ]);
    }

    #[Route('/inventaire/lister_capteurs', name: 'listerCapteurs')]
    public function lister_capteurs(ManagerRegistry $doctrine): Response
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
    public function ajouter_capteur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sensor = new Sensor();
        $form = $this->createForm(SensorType::class, $sensor);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($sensor);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerCapteurs',[]));

        }
        return $this->render('admin/ajouter_capteur.html.twig', [
            'form' =>$form->createView(),
        ]);

    }

    #[Route('/inventaire/ajouter_salle', name: 'ajouter_salle')]
    public function ajouter_salle(Request $request, ManagerRegistry $doctrine): Response
    {
        $room = new Room();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($room);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerSalles',[]));
        }

        return $this->render('admin/ajouter_salle.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    #[Route('/inventaire/ajouter_systeme', name: 'ajouterSystemes')]
    public function add_system(Request $request, EntityManagerInterface $entityManager): Response
    {
        $system = new System();

        $form = $this->createForm(SystemType::class, $system);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($system);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerSystemes',[]));
        }

        return $this->render('admin/ajouter_systeme.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/inventaire/modifier_systeme/{id?}', name: 'modifierSystemes')]
    public function update_system(Request $request, ?int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $system = $repository->find($id);

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
    public function update_capteur(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager =$doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $sensor = $repository->find($id);
        $form = $this->createForm(SensorType::class, $sensor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($sensor);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('listerCapteurs', []));
        }

        return $this->render('admin/ajouter_capteur.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inventaire/supprimer_capteur/{id?}', name: 'supprimerCapteur')]
    public function supprimer_capteur(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $sensor = $repository->find($id);
        $entityManager->remove($sensor);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('listerCapteurs', []));


    }
    #[Route('/inventaire/supprimer_systeme/{id?}', name: 'supprimerSysteme')]
    public function supprimer_systeme(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $system = $repository->find($id);
        $entityManager->remove($system);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('listerSystemes'));
    }

    #[Route('/inventaire/supprimer_salle/{id?}', name: 'supprimerSalle')]
    public function supprimer_salle(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->find($id);

        return $this->redirect($this->generateUrl('listerSalles', ['ok' => $repository->remove($room, true)]));
    }

    #[Route('admin/selection_salle', name: 'selectionSalle')]
    public function selection_salle(ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach($allRoom as $room)
        {
            $handler->handle(new DonneesCapteursQuery($room, $doctrine));
        }

        return $this->render('admin/selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
        ]);

    }
    #[Route('/admin/donnees_salle_admin/{room?}', name: 'donneesSalleAdmin')]
    public function donnees_salle_admin(?Room $room, ManagerRegistry $doctrine, DonneesCapteursHandler $handler,ConseilAlerteHandler $handler2): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        //pour mettre les alertes
        foreach($allRoom as $rooms)
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
            'dateT'=> $donnees["T"]->dateCapture,
            'dateH'=> $donnees["H"]->dateCapture,
            'dateC'=> $donnees["C"]->dateCapture,
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
    public function suivi_selection_salle(Request $request, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach($allRoom as $room)
        {
            $handler->handle(new DonneesCapteursQuery($room, $doctrine));
        }

        return $this->render('admin/suivi_selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
        ]);

    }

    #[Route('/admin/suivi/graphique/{room?}', name: 'graph_admin')]
    public function graphique_admin(?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $statTemp= new Stat\Stat();
        $statHum= new Stat\Stat();
        $statCo2= new Stat\Stat();
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach($allRoom as $rooms)
        {
            $handler->handle(new DonneesCapteursQuery($rooms, $doctrine));
        }

        $donnees=$handler->handleGraph(new DonneesCapteursQuery($room, $doctrine));             // Récupération de toutes les données de l'API

        foreach($donnees["T"] as $temp){

            $statTemp->PushToArrayDateMonth($statTemp->transformMonth($temp->dateCapture),doubleval($temp->valeur));        // On classe les données en fonction de leur mois
            $statTemp->PushToArrayDateDay(($statTemp->transformDay($temp->dateCapture)),doubleval($temp->valeur));

        }


        $dataDayTemp=$statTemp->PopulateDayAsLabel(11);
        $moyTemp=json_encode($statTemp->PopulateMoy());                 // On calcule la moyenne de chaque mois et on structure en tableau

        foreach($donnees["H"] as $hum){

            $statHum->PushToArrayDateMonth($statHum->transformMonth($hum->dateCapture),doubleval($hum->valeur));        // Hum
            $statHum->PushToArrayDateDay(($statHum->transformDay($hum->dateCapture)),doubleval($hum->valeur));

        }


        $dataDayHum=$statHum->PopulateDayAsLabel(11);
        $moyHum=json_encode($statHum->PopulateMoy());       // Hum

        foreach($donnees["C"] as $co2){

            $statCo2->PushToArrayDateMonth($statCo2->transformMonth($co2->dateCapture),doubleval($co2->valeur));        // Co2
            $statCo2->PushToArrayDateDay(($statCo2->transformDay($co2->dateCapture)),doubleval($co2->valeur));

        }

        $dataDayCo2=$statCo2->PopulateDayAsLabel(11);
        $moyCo2=json_encode($statCo2->PopulateMoy());       // Co2


        return $this->render('admin/graphique.html.twig', [
            'room' => $room,
            'dataTemp' =>$moyTemp,
            'dataHum' =>$moyHum,
            'dataCo2' =>$moyCo2,
            'dataDayTemp'=>$dataDayTemp,
            'dataDayHum' =>$dataDayHum,
            'dataDayCo2' =>$dataDayCo2,
            //'data'=>$dataDay,

        ]);
    }

    #[Route('admin/alerte_selection', name: 'alerte_selection')]
    public function alerte_selection_salle(ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        //initialization
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

        //for all room
        foreach($allRoom as $room)
        {
            /* appel alerte_count */
            $nbAlert[$room->getId()] = $this->alerte_count($room, $doctrine, $handler,$date1,$date2);

        }
        return $this->render('admin/alerte_selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
            'nbAlert' =>$nbAlert,
        ]);

    }

    //take two dates and count the number of alert of all type for a specific room and stock them into an array of ["T"], ["C"], ["H"]
    public function alerte_count(?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler,String $date1, String $date2): array
    {
        //the array we return
        $nbAlert = array();
        //to avoid the room without data in it
        if($room->getName()!="Stock"){
            //effective call to the function with all parameter
            $nbAlert= $handler->handleNbAlert(new DonneesCapteursQuery($room, $doctrine),$date1,$date2);
        }
        return $nbAlert;
    }

    #[Route('/admin/alerte_detail/{room?}', name: 'alerte_vision_admin')]
    public function alerte_detail(?Room $room,ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
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
        $nbAlert=array();

        if($room->getName() != "Stock"){
            //initialize
            $nbAlert=$this->alerte_count($room, $doctrine, $handler,$date1,$date2);
        }
        return $this->render('admin/alerteStat.html.twig', [
            'room' => $room,
            'nbAlert' =>$nbAlert,
        ]);
    }

}


