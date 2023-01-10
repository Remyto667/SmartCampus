<?php

namespace App\DataFixtures;

use App\Domain\Alert;
use App\Entity\Room;
use App\Entity\Sensor;
use App\Entity\System;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
// Admin
        $admin = new User();
        $hash='$2y$13$nsVjukfaWtKD7JXsy1AUS.Ye0xn.9Ofet/7Db9ucxHQsc6CmxTkuq'; //admin
        $admin->setPassword($hash);
        $admin->setUsername("admin");
        $admin->SetRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

// Technicien
        $tech = new User();
        $hash='$2y$13$57i6DzDxoYj7x9MU4JfurOzAhAawvQeJ1Hx0i8rwJA8f2Y1uulZ2C'; //tech $2y$13$Gru6EdJc//C7NqYiqzg2jezgJbfacqcYV0QComjCohtsLHYCDiaxu
        $tech->setPassword($hash);
        $tech->setUsername("technicien");
        $tech->SetRoles(array('ROLE_TECH'));
        $manager->persist($tech);

// type de salle pour les seuils
        $type1= new Type();
        $type1->setName("Salle de classe");
        $type1->setTempMin(19);
        $type1->setTempMax(21);
        $type1->setCo2Max(800);
        $type1->setCo2Min(400);
        $type1->setHumMax(60);
        $type1->setHumMin(40);
        $manager->persist($type1);

        $type2= new Type();
        $type2->setName("Serveur");
        $type2->setTempMin(16);
        $type2->setTempMax(19);
        $type2->setCo2Max(800);
        $type2->setCo2Min(400);
        $type2->setHumMax(60);
        $type2->setHumMin(40);
        $manager->persist($type2);

        $type3= new Type();
        $type3->setName("Bureau");
        $type3->setTempMin(19);
        $type3->setTempMax(21);
        $type3->setCo2Max(800);
        $type3->setCo2Min(400);
        $type3->setHumMax(60);
        $type3->setHumMin(40);
        $manager->persist($type3);

        $type4= new Type();
        $type4->setName("Secrétariat");
        $type4->setTempMin(19);
        $type4->setTempMax(21);
        $type4->setCo2Max(800);
        $type4->setCo2Min(400);
        $type4->setHumMax(60);
        $type4->setHumMin(40);
        $manager->persist($type4);


// Les salles
        $room1=new Room();
        $room1->setName("D207");
        $room1->setFloor(2);
        $room1->setOrientation("N");
        $room1->setRoomSize(45);
        $room1->setType($type1);
        $room1->setWindowsNumber(4);
        $room1->setTempAlert(new Alert(false, ''));
        $room1->setHumAlert(new Alert(false, ''));
        $room1->setCo2Alert(new Alert(false, ''));
        $manager->persist($room1);

        $room2=new Room();
        $room2->setName("D206");
        $room2->setFloor(2);
        $room2->setOrientation("N");
        $room2->setRoomSize(44);
        $room2->setType($type1);
        $room2->setWindowsNumber(5);
        $room2->setTempAlert(new Alert(false, ''));
        $room2->setHumAlert(new Alert(false, ''));
        $room2->setCo2Alert(new Alert(false, ''));
        $manager->persist($room2);

        $room3=new Room();
        $room3->setName("D304");
        $room3->setFloor(3);
        $room3->setOrientation("S");
        $room3->setRoomSize(50);
        $room3->setType($type1);
        $room3->setWindowsNumber(3);
        $room3->setTempAlert(new Alert(false, ''));
        $room3->setHumAlert(new Alert(false, ''));
        $room3->setCo2Alert(new Alert(false, ''));
        $manager->persist($room3);

        $room4=new Room();
        $room4->setName("D303");
        $room4->setFloor(3);
        $room4->setOrientation("N");
        $room4->setRoomSize(45);
        $room4->setType($type1);
        $room4->setWindowsNumber(4);
        $room4->setTempAlert(new Alert(false, ''));
        $room4->setHumAlert(new Alert(false, ''));
        $room4->setCo2Alert(new Alert(false, ''));
        $manager->persist($room4);

        $room5=new Room();
        $room5->setName("D002");
        $room5->setFloor(0);
        $room5->setOrientation("N");
        $room5->setRoomSize(53);
        $room5->setType($type1);
        $room5->setWindowsNumber(6);
        $room5->setTempAlert(new Alert(false, ''));
        $room5->setHumAlert(new Alert(false, ''));
        $room5->setCo2Alert(new Alert(false, ''));
        $manager->persist($room5);

        $room6=new Room();
        $room6->setName("Stock");
        $room6->setFloor(0);
        $room6->setOrientation("S");
        $room6->setRoomSize(45);
        $room6->setType($type3);
        $room6->setWindowsNumber(2);
        $room6->setIsStock(true);
        $room6->setTempAlert(new Alert(false, ''));
        $room6->setHumAlert(new Alert(false, ''));
        $room6->setCo2Alert(new Alert(false, ''));
        $manager->persist($room6);

        $room7=new Room();
        $room7->setName("D205");
        $room7->setFloor(2);
        $room7->setOrientation("S");
        $room7->setRoomSize(45);
        $room7->setType($type1);
        $room7->setWindowsNumber(4);
        $room7->setIsStock(false);
        $room7->setTempAlert(new Alert(false, ''));
        $room7->setHumAlert(new Alert(false, ''));
        $room7->setCo2Alert(new Alert(false, ''));
        $manager->persist($room7);

        $room8=new Room();
        $room8->setName("D204");
        $room8->setFloor(2);
        $room8->setOrientation("N");
        $room8->setRoomSize(45);
        $room8->setType($type1);
        $room8->setWindowsNumber(4);
        $room8->setIsStock(false);
        $room8->setTempAlert(new Alert(false, ''));
        $room8->setHumAlert(new Alert(false, ''));
        $room8->setCo2Alert(new Alert(false, ''));
        $manager->persist($room8);

        $room9=new Room();
        $room9->setName("D203");
        $room9->setFloor(2);
        $room9->setOrientation("S");
        $room9->setRoomSize(55);
        $room9->setType($type2);
        $room9->setWindowsNumber(4);
        $room9->setIsStock(false);
        $room9->setTempAlert(new Alert(false, ''));
        $room9->setHumAlert(new Alert(false, ''));
        $room9->setCo2Alert(new Alert(false, ''));
        $manager->persist($room9);

        $room10=new Room();
        $room10->setName("C101");
        $room10->setFloor(1);
        $room10->setOrientation("S");
        $room10->setRoomSize(55);
        $room10->setType($type3);
        $room10->setWindowsNumber(5);
        $room10->setIsStock(false);
        $room10->setTempAlert(new Alert(false, ''));
        $room10->setHumAlert(new Alert(false, ''));
        $room10->setCo2Alert(new Alert(false, ''));
        $manager->persist($room10);

        $room11=new Room();
        $room11->setName("C109");
        $room11->setFloor(1);
        $room11->setOrientation("S");
        $room11->setRoomSize(55);
        $room11->setType($type3);
        $room11->setWindowsNumber(5);
        $room11->setIsStock(false);
        $room11->setTempAlert(new Alert(false, ''));
        $room11->setHumAlert(new Alert(false, ''));
        $room11->setCo2Alert(new Alert(false, ''));
        $manager->persist($room11);

        $room12=new Room();
        $room12->setName("Secrétariat");
        $room12->setFloor(1);
        $room12->setOrientation("N");
        $room12->setRoomSize(40);
        $room12->setType($type4);
        $room12->setWindowsNumber(2);
        $room12->setIsStock(false);
        $room12->setTempAlert(new Alert(false, ''));
        $room12->setHumAlert(new Alert(false, ''));
        $room12->setCo2Alert(new Alert(false, ''));
        $manager->persist($room12);

        $room13=new Room();
        $room13->setName("D001");
        $room13->setFloor(0);
        $room13->setOrientation("N");
        $room13->setRoomSize(60);
        $room13->setType($type1);
        $room13->setWindowsNumber(5);
        $room13->setIsStock(false);
        $room13->setTempAlert(new Alert(false, ''));
        $room13->setHumAlert(new Alert(false, ''));
        $room13->setCo2Alert(new Alert(false, ''));
        $manager->persist($room13);

        $room14=new Room();
        $room14->setName("D004");
        $room14->setFloor(0);
        $room14->setOrientation("S");
        $room14->setRoomSize(60);
        $room14->setType($type1);
        $room14->setWindowsNumber(5);
        $room14->setIsStock(false);
        $room14->setTempAlert(new Alert(false, ''));
        $room14->setHumAlert(new Alert(false, ''));
        $room14->setCo2Alert(new Alert(false, ''));
        $manager->persist($room14);

        $room15=new Room();
        $room15->setName("C003");
        $room15->setFloor(0);
        $room15->setOrientation("N");
        $room15->setRoomSize(60);
        $room15->setType($type1);
        $room15->setWindowsNumber(5);
        $room15->setIsStock(false);
        $room15->setTempAlert(new Alert(false, ''));
        $room15->setHumAlert(new Alert(false, ''));
        $room15->setCo2Alert(new Alert(false, ''));
        $manager->persist($room15);

        $room16=new Room();
        $room16->setName("C007");
        $room16->setFloor(0);
        $room16->setOrientation("N");
        $room16->setRoomSize(60);
        $room16->setType($type1);
        $room16->setWindowsNumber(5);
        $room16->setIsStock(false);
        $room16->setTempAlert(new Alert(false, ''));
        $room16->setHumAlert(new Alert(false, ''));
        $room16->setCo2Alert(new Alert(false, ''));
        $manager->persist($room16);

//Les systemes

        $system1=new System();
        $system1->setName("systeme 1");
        $system1->setRoom($room1);
        $system1->setTag(3);
        $manager->persist($system1);

        $system2=new System();
        $system2->setName("systeme 2");
        $system2->setRoom($room2);
        $system2->setTag(2);
        $manager->persist($system2);

        $system3=new System();
        $system3->setName("systeme 3");
        $system3->setRoom($room3);
        $system3->setTag(7);
        $manager->persist($system3);

        $system4=new System();
        $system4->setName("systeme 4");
        $system4->setRoom($room4);
        $system4->setTag(6);
        $manager->persist($system4);

        $system5=new System();
        $system5->setName("systeme 5");
        $system5->setRoom($room5);
        $system5->setTag(12);
        $manager->persist($system5);

        $system6=new System();
        $system6->setName("systeme 6");
        $system6->setRoom($room10);
        $system6->setTag(8);
        $manager->persist($system6);

        $system7=new System();
        $system7->setName("systeme 7");
        $system7->setRoom($room7);
        $system7->setTag(1);
        $manager->persist($system7);

        $system8=new System();
        $system8->setName("systeme 8");
        $system8->setRoom($room8);
        $system8->setTag(4);
        $manager->persist($system8);

        $system9=new System();
        $system9->setName("systeme 9");
        $system9->setRoom($room9);
        $system9->setTag(5);
        $manager->persist($system9);

        $system10=new System();
        $system10->setName("systeme 10");
        $system10->setRoom($room11);
        $system10->setTag(9);
        $manager->persist($system10);

        $system11=new System();
        $system11->setName("systeme 11");
        $system11->setRoom($room12);
        $system11->setTag(10);
        $manager->persist($system11);

        $system12=new System();
        $system12->setName("systeme 12");
        $system12->setRoom($room13);
        $system12->setTag(11);
        $manager->persist($system12);

        $system13=new System();
        $system13->setName("systeme 13");
        $system13->setRoom($room14);
        $system13->setTag(13);
        $manager->persist($system13);

        $system14=new System();
        $system14->setName("systeme 14");
        $system14->setRoom($room15);
        $system14->setTag(14);
        $manager->persist($system14);

        $system15=new System();
        $system15->setName("systeme 14");
        $system15->setRoom($room16);
        $system15->setTag(15);
        $manager->persist($system15);

// Les capteur

//      -----------System 1--------------------------------

        $sensor1=new Sensor();
        $sensor1->setName("capteur 1");
        $sensor1->setState("fonctionnel");
        $sensor1->setSystems($system1);
        $sensor1->setType("temperature");
        $manager->persist($sensor1);

        $sensor2=new Sensor();
        $sensor2->setName("capteur 2");
        $sensor2->setState("fonctionnel");
        $sensor2->setSystems($system1);
        $sensor2->setType("humidite");
        $manager->persist($sensor2);

        $sensor3=new Sensor();
        $sensor3->setName("capteur 3");
        $sensor3->setState("fonctionnel");
        $sensor3->setSystems($system1);
        $sensor3->setType("CO2");
        $manager->persist($sensor3);

//    --------- System 2-----------------------------------

        $sensor4=new Sensor();
        $sensor4->setName("capteur 4");
        $sensor4->setState("fonctionnel");
        $sensor4->setSystems($system2);
        $sensor4->setType("temperature");
        $manager->persist($sensor4);

        $sensor5=new Sensor();
        $sensor5->setName("capteur 5");
        $sensor5->setState("fonctionnel");
        $sensor5->setSystems($system2);
        $sensor5->setType("humidite");
        $manager->persist($sensor5);

        $sensor6=new Sensor();
        $sensor6->setName("capteur 6");
        $sensor6->setState("fonctionnel");
        $sensor6->setSystems($system2);
        $sensor6->setType("CO2");
        $manager->persist($sensor6);

//    --------- System 3----------------------------------

        $sensor7=new Sensor();
        $sensor7->setName("capteur 7");
        $sensor7->setState("fonctionnel");
        $sensor7->setSystems($system3);
        $sensor7->setType("temperature");
        $manager->persist($sensor7);

        $sensor8=new Sensor();
        $sensor8->setName("capteur 8");
        $sensor8->setState("fonctionnel");
        $sensor8->setSystems($system3);
        $sensor8->setType("humidite");
        $manager->persist($sensor8);

        $sensor9=new Sensor();
        $sensor9->setName("capteur 9");
        $sensor9->setState("fonctionnel");
        $sensor9->setSystems($system3);
        $sensor9->setType("CO2");
        $manager->persist($sensor9);

//    --------- System 4--------------------------------------

        $sensor10=new Sensor();
        $sensor10->setName("capteur 10");
        $sensor10->setState("fonctionnel");
        $sensor10->setSystems($system4);
        $sensor10->setType("temperature");
        $manager->persist($sensor10);

        $sensor11=new Sensor();
        $sensor11->setName("capteur 11");
        $sensor11->setState("fonctionnel");
        $sensor11->setSystems($system4);
        $sensor11->setType("humidite");
        $manager->persist($sensor11);

        $sensor12=new Sensor();
        $sensor12->setName("capteur 12");
        $sensor12->setState("fonctionnel");
        $sensor12->setSystems($system4);
        $sensor12->setType("CO2");
        $manager->persist($sensor12);

//    --------- System 5--------------------------------------

        $sensor13=new Sensor();
        $sensor13->setName("capteur 13");
        $sensor13->setState("fonctionnel");
        $sensor13->setSystems($system5);
        $sensor13->setType("temperature");
        $manager->persist($sensor13);

        $sensor14=new Sensor();
        $sensor14->setName("capteur 14");
        $sensor14->setState("fonctionnel");
        $sensor14->setSystems($system5);
        $sensor14->setType("humidite    ");
        $manager->persist($sensor14);

        $sensor15=new Sensor();
        $sensor15->setName("capteur 15");
        $sensor15->setState("fonctionnel");
        $sensor15->setSystems($system5);
        $sensor15->setType("CO2");
        $manager->persist($sensor15);
        //    --------- System 6--------------------------------------

        $sensor16=new Sensor();
        $sensor16->setName("capteur 16");
        $sensor16->setState("fonctionnel");
        $sensor16->setSystems($system6);
        $sensor16->setType("temperature");
        $manager->persist($sensor16);

        $sensor17=new Sensor();
        $sensor17->setName("capteur 17");
        $sensor17->setState("fonctionnel");
        $sensor17->setSystems($system6);
        $sensor17->setType("CO2");
        $manager->persist($sensor17);

        $manager->flush();
    }
}
