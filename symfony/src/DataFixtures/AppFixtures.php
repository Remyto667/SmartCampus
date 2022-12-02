<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\Sensor;
use App\Entity\System;
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

        $room6=new Room();
        $room6->setName("Stock");
        $manager->persist($room6);

//Les systemes

        $system1=new System();
        $system1->setName("system1");
        $system1->setRoom($room1);
        $system1->setTag(1);
        $manager->persist($system1);

        $system2=new System();
        $system2->setName("system2");
        $system2->setRoom($room2);
        $system2->setTag(2);
        $manager->persist($system2);

        $system3=new System();
        $system3->setName("system3");
        $system3->setRoom($room3);
        $system3->setTag(3);
        $manager->persist($system3);

        $system4=new System();
        $system4->setName("system4");
        $system4->setRoom($room4);
        $system4->setTag(4);
        $manager->persist($system4);

        $system5=new System();
        $system5->setName("system5");
        $system5->setRoom($room5);
        $system5->setTag(5);
        $manager->persist($system5);

        $system6=new System();
        $system6->setName("system6");
        $system6->setRoom($room1);
        $system6->setTag(1);
        $manager->persist($system6);

// Les capteurs

//      -----------System 1--------------------------------

        $sensor1=new Sensor();
        $sensor1->setName("sensor1");
        $sensor1->setState("fonctionnel");
        $sensor1->setSystems($system1);
        $sensor1->setType("temperature");
        $manager->persist($sensor1);

        $sensor2=new Sensor();
        $sensor2->setName("sensor2");
        $sensor2->setState("fonctionnel");
        $sensor2->setSystems($system1);
        $sensor2->setType("humidite");
        $manager->persist($sensor2);

        $sensor3=new Sensor();
        $sensor3->setName("sensor3");
        $sensor3->setState("fonctionnel");
        $sensor3->setSystems($system1);
        $sensor3->setType("CO2");
        $manager->persist($sensor3);

//    --------- System 2-----------------------------------

        $sensor4=new Sensor();
        $sensor4->setName("sensor4");
        $sensor4->setState("fonctionnel");
        $sensor4->setSystems($system2);
        $sensor4->setType("temperature");
        $manager->persist($sensor4);

        $sensor5=new Sensor();
        $sensor5->setName("sensor5");
        $sensor5->setState("fonctionnel");
        $sensor5->setSystems($system2);
        $sensor5->setType("humidite");
        $manager->persist($sensor5);

        $sensor6=new Sensor();
        $sensor6->setName("sensor6");
        $sensor6->setState("fonctionnel");
        $sensor6->setSystems($system2);
        $sensor6->setType("CO2");
        $manager->persist($sensor6);

//    --------- System 3----------------------------------

        $sensor7=new Sensor();
        $sensor7->setName("sensor7");
        $sensor7->setState("fonctionnel");
        $sensor7->setSystems($system3);
        $sensor7->setType("temperature");
        $manager->persist($sensor7);

        $sensor8=new Sensor();
        $sensor8->setName("sensor8");
        $sensor8->setState("fonctionnel");
        $sensor8->setSystems($system3);
        $sensor8->setType("humidite");
        $manager->persist($sensor8);

        $sensor9=new Sensor();
        $sensor9->setName("sensor9");
        $sensor9->setState("fonctionnel");
        $sensor9->setSystems($system3);
        $sensor9->setType("CO2");
        $manager->persist($sensor9);

//    --------- System 4--------------------------------------

        $sensor10=new Sensor();
        $sensor10->setName("sensor10");
        $sensor10->setState("fonctionnel");
        $sensor10->setSystems($system4);
        $sensor10->setType("temperature");
        $manager->persist($sensor10);

        $sensor11=new Sensor();
        $sensor11->setName("sensor11");
        $sensor11->setState("fonctionnel");
        $sensor11->setSystems($system4);
        $sensor11->setType("humidite");
        $manager->persist($sensor11);

        $sensor12=new Sensor();
        $sensor12->setName("sensor12");
        $sensor12->setState("fonctionnel");
        $sensor12->setSystems($system4);
        $sensor12->setType("CO2");
        $manager->persist($sensor12);

//    --------- System 5--------------------------------------

        $sensor13=new Sensor();
        $sensor13->setName("sensor13");
        $sensor13->setState("fonctionnel");
        $sensor13->setSystems($system5);
        $sensor13->setType("temperature");
        $manager->persist($sensor13);

        $sensor14=new Sensor();
        $sensor14->setName("sensor14");
        $sensor14->setState("fonctionnel");
        $sensor14->setSystems($system5);
        $sensor14->setType("humidite    ");
        $manager->persist($sensor14);

        $sensor15=new Sensor();
        $sensor15->setName("sensor15");
        $sensor15->setState("fonctionnel");
        $sensor15->setSystems($system5);
        $sensor15->setType("CO2");
        $manager->persist($sensor15);
        //    --------- System 6--------------------------------------

        $sensor16=new Sensor();
        $sensor16->setName("sensor16");
        $sensor16->setState("fonctionnel");
        $sensor16->setSystems($system6);
        $sensor16->setType("temperature");
        $manager->persist($sensor16);

        $sensor17=new Sensor();
        $sensor17->setName("sensor17");
        $sensor17->setState("fonctionnel");
        $sensor17->setSystems($system6);
        $sensor17->setType("CO2");
        $manager->persist($sensor17);

        $manager->flush();
    }
}
