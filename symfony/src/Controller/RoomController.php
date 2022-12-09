<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomChoice;
use App\Form\RoomType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\All;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'app_room')]
    public function index(): Response
    {
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }

    #[Route('/salle/selection', name: 'selection')]
    public function connexion_salle(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        return $this->render('salle/selection.html.twig', [
            'allRoom' => $allRoom,
        ]);

    }



    #[Route('/salle/{room?}', name: 'donneesSalle')]
    public function donnees_salle(Request $request, ?Room $room, ManagerRegistry $doctrine): Response{

        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');

        $jsonT = "../assets/json/".$room->getName()."-temp.json";
        $jsonH = "../assets/json/".$room->getName()."-hum.json";
        $jsonC = "../assets/json/".$room->getName()."-co2.json";
        $fileT = file_get_contents($jsonT);
        $fileH = file_get_contents($jsonH);
        $fileC = file_get_contents($jsonC);
        $objT = json_decode($fileT);
        $objH = json_decode($fileH);
        $objC = json_decode($fileC);

        return $this->render('salle/donnees_salle.html.twig', [
            'id' => $room->getId(),
            'room' => $room->getName(),
            'temp' => $objT[0]->valeur,
            'hum' => $objH[0]->valeur,
            'co2' => $objC[0]->valeur,
        ]);    }

    #[Route('/salle/alerte/{room?}/{id?}', name: 'alerte')]
    public function alerte_salle(Request $request, ?Room $room, ?int $id, ManagerRegistry $doctrine): Response{

        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');

        $jsonT = "../assets/json/".$room->getName()."-temp.json";
        $jsonH = "../assets/json/".$room->getName()."-hum.json";
        $jsonC = "../assets/json/".$room->getName()."-co2.json";
        $fileT = file_get_contents($jsonT);
        $fileH = file_get_contents($jsonH);
        $fileC = file_get_contents($jsonC);
        $objT = json_decode($fileT);
        $objH = json_decode($fileH);
        $objC = json_decode($fileC);

        return $this->render('salle/alerte.html.twig', [
            'id' => $id,
            'room' => $room->getName(),
            'temp' => $objT[0]->valeur,
            'hum' => $objH[0]->valeur,
            'co2' => $objC[0]->valeur,
        ]);    }

}
