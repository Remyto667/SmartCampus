<?php

namespace App\Domain\Query;

use App\Entity\Room;

class DonneesCapteursQuery
{
    private $room;

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    public function __construct(Room $room)
    {
        $this->room = $room;
    }
}