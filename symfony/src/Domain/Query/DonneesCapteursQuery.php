<?php

namespace App\Domain\Query;

use App\Entity\Room;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class DonneesCapteursQuery
{
    private Room $room;
    private ManagerRegistry $doctrine;

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    public function getTag(): int
    {
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $systems = $repository->findBy(['room' => $this->room->getId()]);
        if (sizeof($systems) > 0) {
            return $systems[0]->getTag();
        }
        else {
            return 0;
        }
    }

    public function __construct(Room &$room, ManagerRegistry $doctrine)
    {
        $this->room = $room;
        $this->doctrine = $doctrine;
    }

}