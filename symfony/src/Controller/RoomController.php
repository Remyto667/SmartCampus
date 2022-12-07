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
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }

    #[Route('/salle/connexion', name: 'connexion_salle')]
    public function connexion_salle(Request $request, ManagerRegistry $doctrine): Response
    {
        $room = new Room();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(RoomChoice::class, $room);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            return $this->redirect($this->generateUrl('/salle/{$form}',[]));
        }

        return $this->render('room/connexion.html.twig', [
            'form' =>$form->createView()
        ]);

    }

    #[Route('/salle/{name?}', name: 'donneesSalle')]
    public function donnees_salle(Request $request, ?string $name, ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Room');
        $room = $repository->findRoomByName($name);

        $json = "../assets/json/".$room->getName().".json";
        $file = file_get_contents($json);
        $obj = json_decode($file);

        return $this->render('room/donnees_salle.html.twig', [
            'obj' => $obj,
            'room' => $obj[0]->{"localisation"},
            'temp' => $obj[0]->{"valeur"},
            'hum' => $obj[1]->{"valeur"},
            'co2' => $obj[2]->{"valeur"},
        ]);    }

}
