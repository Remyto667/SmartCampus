<?php

namespace App\Domain\Query;

use App\Entity\Conseil;
use App\Entity\Room;
use Doctrine\Persistence\ManagerRegistry;

class ConseilAlerteQuery
{

    private $doctrine;

    private $room;

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    /**
     * @return Room
     */
    public function getTag(): int
    {
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\System');
        $systems = $repository->findBy(['room' => $this->room->getId()]);
        if (sizeof($systems) > 0)
        {
            return $systems[0]->getTag();
        }
        else
        {
            return 0;
        }

    }

    /**
     * @return Conseil
     */
    public function getAdvice($temp_alerte_sup,$temp_alerte_inf,$hum_alerte_sup,$hum_alerte_inf,$co2_alerte_sup,$co2_alerte_inf,$temp_sup_outside,$no_data): int
    {
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Conseil');
        $advice = $repository->findAdvice($temp_alerte_sup,$temp_alerte_inf,$hum_alerte_sup,$hum_alerte_inf,$co2_alerte_sup,$co2_alerte_inf,$temp_sup_outside,$no_data);
        if (sizeof($advice) > 0)
        {
            return $advice;
        }
        else
        {
            return 0;
        }

    }

    public function __construct(Room &$room, ManagerRegistry $doctrine)
    {
        $this->room = $room;
        $this->doctrine = $doctrine;
    }

}
