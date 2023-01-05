<?php

namespace App\Controller;

use App\Domain\Alert;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\All;

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

    #[Route('/admin/profil', name: 'profil_admin')]
    public function connexion_admin(): Response
    {
        return $this->render('admin/profil.html.twig', [
            'controller_name' => 'CONNEXION',
        ]);

    }

    #[Route('/admin/inventaire', name: 'inventaire')]
    public function inventaire(): Response
    {
        return $this->render('admin/inventaire.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/inventaire/lister_salles/{ok?1}', name: 'listerSalles')]
    public function lister_salles(ManagerRegistry $doctrine, ?int $ok, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach($allRoom as $room)
        {
            $handler->handle(new DonneesCapteursQuery($room, $doctrine));
        }

        return $this->render('admin/lister_salles.html.twig', [
            'rooms' => $allRoom,
            'ok' => $ok,
        ]);
    }

    #[Route('/admin/inventaire/lister_systemes', name: 'listerSystemes')]
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

    #[Route('/admin/inventaire/lister_capteurs', name: 'listerCapteurs')]
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

    #[Route('/admin/inventaire/ajouter_capteur', name: 'ajouterCapteur')]
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

    #[Route('/admin/inventaire/ajouter_salle', name: 'ajouter_salle')]
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

    #[Route('/admin/inventaire/ajouter_systeme', name: 'ajouterSystemes')]
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

    #[Route('/admin/inventaire/modifier_systeme/{id?}', name: 'modifierSystemes')]
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

    #[Route('/admin/inventaire/modifier_salle/{id?}', name: 'modifierSalles')]
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

    #[Route('/admin/inventaire/modifier_capteur/{id?}', name: 'modifierCapteurs')]
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

    #[Route('/admin/inventaire/supprimer_capteur/{id?}', name: 'supprimerCapteur')]
    public function supprimer_capteur(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $sensor = $repository->find($id);
        $entityManager->remove($sensor);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('listerCapteurs', []));


    }
    #[Route('/admin/inventaire/supprimer_systeme/{id?}', name: 'supprimerSysteme')]
    public function supprimer_systeme(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $system = $repository->find($id);
        $entityManager->remove($system);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('listerSystemes'));
    }

    #[Route('/admin/inventaire/supprimer_salle/{id?}', name: 'supprimerSalle')]
    public function supprimer_salle(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->find($id);

        return $this->redirect($this->generateUrl('listerSalles', ['ok' => $repository->remove($room, true)]));
    }

    #[Route('admin/selection_salle', name: 'selectionSalle')]
    public function selection_salle(Request $request, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
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
    public function donnees_salle_admin(?Room $room, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach($allRoom as $rooms)
        {
            $handler->handle(new DonneesCapteursQuery($rooms, $doctrine));
        }

        $donnees=$handler->handle(new DonneesCapteursQuery($room, $doctrine));


        return $this->render('admin/donnees_salle_admin.html.twig', [
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

    #[Route('/admin/alerte/{room?}/{id?}', name: 'alerteAdmin')]
    public function alerte_salle_admin(?Room $room, ?int $id, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response{

       $donnees=$handler->handle(new DonneesCapteursQuery($room, $doctrine));

        return $this->render('admin/alerte.html.twig', [
            'id' => $id,
            'room' => $room->getName(),
            'temp' => $donnees["T"]->valeur,
            'hum' => $donnees["H"]->valeur,
            'co2' => $donnees["C"]->valeur,
        ]);    }

    #[Route('/admin/suivi/graphique', name: 'graph_admin')]
    public function graphique_admin(): Response
    {
        return $this->render('admin/graphique.html.twig', [
            'controller_name' => 'graph',
        ]);

    }

    #[Route('/admin/lister_alertes', name: 'listerAlertes')]
    public function liste_alertes(Request $request, ?Room $room, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response{

        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $rooms = $repository->findAll();
        /*$alert = $room->getIsAlert();

        foreach ($rooms as $room)
        {
            $donnees=$handler->handle(new DonneesCapteursQuery($room));
            if ($alert == true)
            {
                $description = "a un pb";
            }
        }*/


        return $this->render('admin/lister_alertes.html.twig', [
            'controller_name' => 'Liste des Alertes',
            'rooms' => $rooms,
            /*'alert' => $alert,
            'temp' => $donnees["T"]->valeur,
            'hum' => $donnees["H"]->valeur,
            'co2' => $donnees["C"]->valeur,
            'desc' => $description,*/
        ]);
    }

}
