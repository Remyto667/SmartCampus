<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function connexion_salle(): Response
    {
        return $this->render('salle/profil.html.twig', [
            'controller_name' => 'CONNEXION SALLE',
        ]);

    }

    #[Route('/salle/alerte/{id?}', name: 'alerte')]
    public function alerte( ?int $id): Response
    {
        $json = '../assets/json/dataRoom.json'; // chemin d'accès à votre fichier JSON
        $file = file_get_contents($json); // mettre le contenu du fichier dans une variable
        $obj = json_decode($file); // décoder le flux JSON

        return $this->render('room/alerte.html.twig', [
            'id' => $id,
            'obj' => $obj,
            'room' => $obj[0]->{"localisation"},
            'temp' => $obj[0]->{"valeur"},
            'hum' => $obj[1]->{"valeur"},
            'co2' => $obj[2]->{"valeur"},
        ]);

    }

}
