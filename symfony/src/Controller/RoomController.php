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
            $entityManager->persist();
            $entityManager->flush();
            return $this->redirect($this->generateUrl('/salle/donnees_salle',[]));
        }

        return $this->render('room/connexion.html.twig', [
            'form' =>$form->createView()
        ]);

    }

}
