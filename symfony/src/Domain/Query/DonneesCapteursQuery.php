<?php

namespace App\Domain\Query;

use App\Entity\Room;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class DonneesCapteursQuery
{
    private $room;
    private $doctrine;

    /**
     * @return Room
     */
    public function getTag(): int
    {
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $systems = $repository->findBy(['room' => $this->room->getId()]);
        return $systems[0]->getTag();

    }

    public function __construct(Room $room, ManagerRegistry $doctrine)
    {
        $this->room = $room;
        $this->doctrine = $doctrine;
    }
}