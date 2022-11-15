<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // Les salles
        $room1=new Room();
        $room1->setName("D207");
        $manager->persist($room1);

        $room2=new Room();
        $room2->setName("D206");
        $manager->persist($room2);

        $room3=new Room();
        $room3->setName("D304");
        $manager->persist($room3);

        $room4=new Room();
        $room4->setName("D302");
        $manager->persist($room4);

        $room5=new Room();
        $room5->setName("D002");
        $manager->persist($room5);
        /*
// Les systemes

        $system1=new System();
        $system1->setName("system1");
        $system1->set

        $system2=new System();
        $system2->setName("system2");

        $system3=new System();
        $system3->setName("system3");

        $system4=new System();
        $system4->setName("system4");

        $system5=new System();
        $system5->setName("system5");

        $system6=new System();
        $system6->setName("system6");

// Les capteurs
*/

        $manager->flush();
    }
}
