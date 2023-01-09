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
    public function getAdvice(bool $temp_alerte_sup,bool $temp_alerte_inf,bool $hum_alerte_sup,bool $hum_alerte_inf,bool $co2_alerte_sup,bool $co2_alerte_inf,bool$temp_sup_outside,bool $no_data): array
    {
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository('App\Entity\Conseil');
        $advice = $repository->findAdvice($temp_alerte_sup,$temp_alerte_inf,$hum_alerte_sup,$hum_alerte_inf,$co2_alerte_sup,$co2_alerte_inf,$temp_sup_outside,$no_data);

        return $advice;


    }

    public function __construct(Room &$room, ManagerRegistry $doctrine)
    {
        $this->room = $room;
        $this->doctrine = $doctrine;
    }

}
