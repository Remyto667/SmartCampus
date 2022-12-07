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
    #[Route('/', name: 'menu')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_admin');
    }
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
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

    #[Route('/admin/database/lister_salles/{ok?1}', name: 'listerSalles')]
    public function lister_salles(ManagerRegistry $doctrine, ?int $ok): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $rooms = $repository->findAll();

        return $this->render('admin/lister_salles.html.twig', [
            'rooms' => $rooms,
            'ok' => $ok,
        ]);
    }

    #[Route('/admin/database/lister_systemes/{ok?1}', name: 'listerSystemes')]
    public function lister_systemes(ManagerRegistry $doctrine, ?int $ok): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $systems = $repository->findAll();
        $repository2 = $entityManager->getRepository('App\Entity\Sensor');
        $nbSensor = $repository2->countSensorOfSystem();

        return $this->render('admin/lister_systemes.html.twig', [
            'systems'=>$systems,
            'nbsensor'=>$nbSensor,
            'ok' => $ok,
        ]);
    }

    #[Route('/admin/database/lister_capteurs', name: 'listerCapteurs')]
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

    #[Route('/admin/database/ajouter_salle', name: 'ajouter_salle')]
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

    #[Route('/admin/database/modifier_salle/{id?}', name: 'modifierSalles')]
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

    #[Route('/admin/database/supprimer_capteur/{id?}', name: 'supprimerCapteur')]
    public function supprimer_capteur(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Sensor');
        $sensor = $repository->find($id);
        $entityManager->remove($sensor);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('listerCapteurs', []));


    }
    #[Route('/admin/database/supprimer_systeme/{id?}', name: 'supprimerSysteme')]
    public function supprimer_systeme(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $system = $repository->find($id);

        return $this->redirect($this->generateUrl('listerSystemes', ['ok' => $repository->remove($system, true)]));
    }

    #[Route('/admin/database/supprimer_salle/{id?}', name: 'supprimerSalle')]
    public function supprimer_salle(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->find($id);

        return $this->redirect($this->generateUrl('listerSalles', ['ok' => $repository->remove($room, true)]));
    }

    #[Route('/admin/database/donnees_salle', name: 'donneesSalle')]
    public function donnees_salle(Request $request, ?int $id, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        //$room = $repository->find($id);

        //return $this->redirect($this->generateUrl('listerSalles', ['ok' => $repository->remove($room, true)]));

        $json = '../assets/json/dataRoom.json'; // chemin d'accès à votre fichier JSON
        $file = file_get_contents($json); // mettre le contenu du fichier dans une variable
        $obj = json_decode($file); // décoder le flux JSON

        /*for ($i=0;$i<sizeof($obj);$i++)
        {
            $nom = $obj[i]->{"nom"}
            switch($nom)
            {
                case "temp":
                    return $this->render('admin/donnees_salle.html.twig', ['temp' => $obj[i]->{"valeur"};]);
                    break;
                
                case "hum":
                    return $this->render('admin/donnees_salle.html.twig', ['hum' => $obj[i]->{"valeur"};]);
                    break;
                
                case "co2":
                    return $this->render('admin/donnees_salle.html.twig', ['co2' => $obj[i]->{"valeur"};]);
                    break;
            }
        }*/


        /*for ($i=0;$i<sizeof($obj);$i++)
        {
            $nom = $obj[i]->{"nom"}

                if($nom == "temp")
                {
                    return $this->render('admin/donnees_salle.html.twig', ['temp' => $obj[i]->{"valeur"};]);
                }

                if($nom == "hum")
                {
                    return $this->render('admin/donnees_salle.html.twig', ['hum' => $obj[i]->{"valeur"};]);
                }

                if($nom == "co2")
                {
                    return $this->render('admin/donnees_salle.html.twig', ['co2' => $obj[i]->{"valeur"};]);
                }
                
            }
        }*/



        //var_dump($obj);

        return $this->render('admin/donnees_salle.html.twig', [
            'obj' => $obj,
            'room' => $obj[0]->{"localisation"},
            'temp' => $obj[0]->{"valeur"},
            'hum' => $obj[1]->{"valeur"},
            'co2' => $obj[2]->{"valeur"},
        ]);    }
}

