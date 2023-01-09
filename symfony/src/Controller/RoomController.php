<?php

namespace App\Controller;

use App\Domain\Alert;
use App\Domain\Query\DonneesCapteursHandler;
use App\Domain\Query\DonneesCapteursQuery;
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
    public function selection_salle(Request $request, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
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
            if (($temp == "NULL" and $hum == "NULL") or ($hum == "NULL" and $co2 == "NULL") or ($temp == "NULL" and $co2 == "NULL") or ($temp == "NULL" and $hum == "NULL" and $co2 == "NULL")) {
                $noData[$room->getId()] = 1;
            } else {
                $noData[$room->getId()] = 0;
            }
        }
        return $this->render('salle/selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloorClassroom(),
            'temp' => $temp,
            'hum' => $hum,
            'co2' => $co2,
            'noData' => $noData,
        ]);

    }

    /*#[Route('/salle/selection', name: 'selection')]
    public function selection_salle_user(Request $request, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response
    {
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $allRoom = $repository->findAll();

        foreach($allRoom as $room)
        {
            $handler->handle(new DonneesCapteursQuery($room, $doctrine));
        }

        return $this->render('salle/selection.html.twig', [
            'allRoom' => $allRoom,
            'allFloor' => $repository->findAllFloor(),
        ]);

    }*/

    #[Route('/salle/{room?}', name: 'donneesSalle')]
    public function donnees_salle(Request $request, ?Room $room, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response{

        $donnees=$handler->handle(new DonneesCapteursQuery($room, $doctrine));

        return $this->render('salle/donnees_salle.html.twig', [
            'room' => $room,
            'id' => $room->getId(),
            'temp' => $donnees["T"]->valeur,
            'hum' => $donnees["H"]->valeur,
            'co2' => $donnees["C"]->valeur,
            'dateT'=> $donnees["T"]->dateCapture,
            'dateH'=> $donnees["H"]->dateCapture,
            'dateC'=> $donnees["C"]->dateCapture,
        ]);    }

    #[Route('/salle/alerte/{roomId?}/{id?}', name: 'alerte')]
    public function alerte_salle(Request $request, ?int $roomId, ?int $id, ManagerRegistry $doctrine, DonneesCapteursHandler $handler): Response{

        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->findOneBy(['id' => $roomId]);

        $donnees=$handler->handle(new DonneesCapteursQuery($room, $doctrine));

        return $this->render('salle/alerte.html.twig', [
            'id' => $id,
            'room' => $room->getName(),
            'temp' => $donnees["T"]->valeur,
            'hum' => $donnees["H"]->valeur,
            'co2' => $donnees["C"]->valeur,
        ]);    }

}
