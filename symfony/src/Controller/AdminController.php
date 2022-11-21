<?php

namespace App\Controller;

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
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/database', name: 'database')]
    public function database(): Response
    {
        return $this->render('admin/database.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/database/lister_salles', name: 'listerSalles')]
    public function lister_salles(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $rooms = $repository->findAll();

        return $this->render('admin/lister_salles.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/admin/database/lister_systemes', name: 'listerSystemes')]
    public function lister_systemes(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $systems = $repository->findAll();

        return $this->render('admin/lister_systemes.html.twig', [
            'systems'=>$systems,
        ]);
    }

    #[Route('/admin/database/lister_capteurs', name: 'listerCapteurs')]
    public function lister_capteurs(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        //$allSensor= $repository->findAll();
        $test = $doctrine->getRepository(Sensor::class)->test();
        return $this->render('admin/lister_capteurs.html.twig', [
            'controller_name' => 'Liste des Capteurs',
            'allSensor' => $test,
        ]);
    }

    #[Route('/admin/database/ajouter_capteur', name: 'ajouterCapteur')]
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

    #[Route('/admin/database/lister_salles/formulaire_ajout', name: 'app_salle_formulaire')]
    public function lister_salles_formulaireAjout(Request $request, ManagerRegistry $doctrine): Response
    {
        $room = new Room();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($room);
            $entityManager->flush();
        }

        return $this->render('admin/formulaire_salles_ajout.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    #[Route('/admin/database/ajouter_systeme', name: 'ajouterSystemes')]
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

    #[Route('/admin/database/modifier_systeme/{id?}', name: 'modifierSystemes')]
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

    #[Route('/admin/database/modifier_capteur/{id?}', name: 'modifierCapteurs')]
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

    #[Route('/admin/database/supprimer_capteur', name: 'supprimerCapteur')]
    public function supprimer_capteur(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager =$doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $sensor = $repository->find($id);
        return 0;
    }
}

