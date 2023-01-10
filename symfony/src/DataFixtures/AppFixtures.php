<?php

namespace App\DataFixtures;

use App\Domain\Alert;
use App\Entity\Conseil;
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
        $hash='$2y$13$nsVjukfaWtKD7JXsy1AUS.Ye0xn.9Ofet/7Db9ucxHQsc6CmxTkuq';
        $admin->setPassword($hash);
        $admin->setUsername("admin");
        $admin->SetRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

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
        $room10->setType($type2);
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
        $room11->setType($type2);
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

// Les Conseils
        //rien
        $conseil1 = new Conseil();
        $conseil1->setConseil("");
        $conseil1->setTempAlerteSup(false);
        $conseil1->setTempAlerteInf(false);
        $conseil1->setHumAlerteSup(false);
        $conseil1->setHumAlerteInf(false);
        $conseil1->setCo2AlerteSup(false);
        $conseil1->setCo2AlerteInf(false);
        $conseil1->setTempSupOutside(false);
        $conseil1->setNoData(false);
        $manager->persist($conseil1);

        //alerte unitaire
        $conseil2 = new Conseil();
        $conseil2->setConseil("Ouvrez les fenetres et les portes pour faire circuler l'air");
        $conseil2->setTempAlerteSup(true);
        $conseil2->setTempAlerteInf(false);
        $conseil2->setHumAlerteSup(false);
        $conseil2->setHumAlerteInf(false);
        $conseil2->setCo2AlerteSup(false);
        $conseil2->setCo2AlerteInf(false);
        $conseil2->setTempSupOutside(false);
        $conseil2->setNoData(false);
        $manager->persist($conseil2);

        $conseil3 = new Conseil();
        $conseil3->setConseil("aide 2");
        $conseil3->setTempAlerteSup(false);
        $conseil3->setTempAlerteInf(true);
        $conseil3->setHumAlerteSup(false);
        $conseil3->setHumAlerteInf(false);
        $conseil3->setCo2AlerteSup(false);
        $conseil3->setCo2AlerteInf(false);
        $conseil3->setTempSupOutside(false);
        $conseil3->setNoData(false);
        $manager->persist($conseil3);

        $conseil4 = new Conseil();
        $conseil4->setConseil("aide 3");
        $conseil4->setTempAlerteSup(false);
        $conseil4->setTempAlerteInf(false);
        $conseil4->setHumAlerteSup(true);
        $conseil4->setHumAlerteInf(false);
        $conseil4->setCo2AlerteSup(false);
        $conseil4->setCo2AlerteInf(false);
        $conseil4->setTempSupOutside(false);
        $conseil4->setNoData(false);
        $manager->persist($conseil4);

        $conseil5 = new Conseil();
        $conseil5->setConseil("augmentez la température");
        $conseil5->setTempAlerteSup(false);
        $conseil5->setTempAlerteInf(false);
        $conseil5->setHumAlerteSup(false);
        $conseil5->setHumAlerteInf(true);
        $conseil5->setCo2AlerteSup(false);
        $conseil5->setCo2AlerteInf(false);
        $conseil5->setTempSupOutside(false);
        $conseil5->setNoData(false);
        $manager->persist($conseil5);

        $conseil6 = new Conseil();
        $conseil6->setConseil("augmentez la température");
        $conseil6->setTempAlerteSup(false);
        $conseil6->setTempAlerteInf(false);
        $conseil6->setHumAlerteSup(false);
        $conseil6->setHumAlerteInf(false);
        $conseil6->setCo2AlerteSup(true);
        $conseil6->setCo2AlerteInf(false);
        $conseil6->setTempSupOutside(false);
        $conseil6->setNoData(false);
        $manager->persist($conseil6);

        $conseil7 = new Conseil();
        $conseil7->setConseil("augmentez la température");
        $conseil7->setTempAlerteSup(false);
        $conseil7->setTempAlerteInf(false);
        $conseil7->setHumAlerteSup(false);
        $conseil7->setHumAlerteInf(false);
        $conseil7->setCo2AlerteSup(false);
        $conseil7->setCo2AlerteInf(true);
        $conseil7->setTempSupOutside(false);
        $conseil7->setNoData(false);
        $manager->persist($conseil7);


        //toute les alertes superieures ensemble
        $conseil8 = new Conseil();
        $conseil8->setConseil("aide 8");
        $conseil8->setTempAlerteSup(true);
        $conseil8->setTempAlerteInf(false);
        $conseil8->setHumAlerteSup(true);
        $conseil8->setHumAlerteInf(false);
        $conseil8->setCo2AlerteSup(false);
        $conseil8->setCo2AlerteInf(false);
        $conseil8->setTempSupOutside(false);
        $conseil8->setNoData(false);
        $manager->persist($conseil8);

        $conseil9 = new Conseil();
        $conseil9->setConseil("aide 9");
        $conseil9->setTempAlerteSup(true);
        $conseil9->setTempAlerteInf(false);
        $conseil9->setHumAlerteSup(false);
        $conseil9->setHumAlerteInf(false);
        $conseil9->setCo2AlerteSup(true);
        $conseil9->setCo2AlerteInf(false);
        $conseil9->setTempSupOutside(false);
        $conseil9->setNoData(false);
        $manager->persist($conseil9);

        $conseil10 = new Conseil();
        $conseil10->setConseil("aide 10");
        $conseil10->setTempAlerteSup(false);
        $conseil10->setTempAlerteInf(false);
        $conseil10->setHumAlerteSup(true);
        $conseil10->setHumAlerteInf(false);
        $conseil10->setCo2AlerteSup(true);
        $conseil10->setCo2AlerteInf(false);
        $conseil10->setTempSupOutside(false);
        $conseil10->setNoData(false);
        $manager->persist($conseil10);

        $conseil11 = new Conseil();
        $conseil11->setConseil("augmentez la température");
        $conseil11->setTempAlerteSup(true);
        $conseil11->setTempAlerteInf(false);
        $conseil11->setHumAlerteSup(true);
        $conseil11->setHumAlerteInf(false);
        $conseil11->setCo2AlerteSup(true);
        $conseil11->setCo2AlerteInf(false);
        $conseil11->setTempSupOutside(false);
        $conseil11->setNoData(false);
        $manager->persist($conseil11);

        //toute les alertes inférieurs ensemble

        $conseil12 = new Conseil();
        $conseil12->setConseil("a");
        $conseil12->setTempAlerteSup(false);
        $conseil12->setTempAlerteInf(true);
        $conseil12->setHumAlerteSup(false);
        $conseil12->setHumAlerteInf(false);
        $conseil12->setCo2AlerteSup(false);
        $conseil12->setCo2AlerteInf(true);
        $conseil12->setTempSupOutside(false);
        $conseil12->setNoData(false);
        $manager->persist($conseil12);

        $conseil13 = new Conseil();
        $conseil13->setConseil("a");
        $conseil13->setTempAlerteSup(false);
        $conseil13->setTempAlerteInf(true);
        $conseil13->setHumAlerteSup(false);
        $conseil13->setHumAlerteInf(true);
        $conseil13->setCo2AlerteSup(false);
        $conseil13->setCo2AlerteInf(false);
        $conseil13->setTempSupOutside(false);
        $conseil13->setNoData(false);
        $manager->persist($conseil13);

        $conseil14 = new Conseil();
        $conseil14->setConseil("a");
        $conseil14->setTempAlerteSup(false);
        $conseil14->setTempAlerteInf(false);
        $conseil14->setHumAlerteSup(false);
        $conseil14->setHumAlerteInf(true);
        $conseil14->setCo2AlerteSup(false);
        $conseil14->setCo2AlerteInf(true);
        $conseil14->setTempSupOutside(false);
        $conseil14->setNoData(false);
        $manager->persist($conseil14);

        $conseil15 = new Conseil();
        $conseil15->setConseil("a");
        $conseil15->setTempAlerteSup(false);
        $conseil15->setTempAlerteInf(true);
        $conseil15->setHumAlerteSup(false);
        $conseil15->setHumAlerteInf(true);
        $conseil15->setCo2AlerteSup(false);
        $conseil15->setCo2AlerteInf(true);
        $conseil15->setTempSupOutside(false);
        $conseil15->setNoData(false);
        $manager->persist($conseil15);

        //2 superieur 1 inferieur
        $conseil16 = new Conseil();
        $conseil16->setConseil("a");
        $conseil16->setTempAlerteSup(true);
        $conseil16->setTempAlerteInf(false);
        $conseil16->setHumAlerteSup(true);
        $conseil16->setHumAlerteInf(false);
        $conseil16->setCo2AlerteSup(false);
        $conseil16->setCo2AlerteInf(true);
        $conseil16->setTempSupOutside(false);
        $conseil16->setNoData(false);
        $manager->persist($conseil16);

        $conseil17 = new Conseil();
        $conseil17->setConseil("a");
        $conseil17->setTempAlerteSup(true);
        $conseil17->setTempAlerteInf(false);
        $conseil17->setHumAlerteSup(false);
        $conseil17->setHumAlerteInf(true);
        $conseil17->setCo2AlerteSup(true);
        $conseil17->setCo2AlerteInf(false);
        $conseil17->setTempSupOutside(false);
        $conseil17->setNoData(false);
        $manager->persist($conseil17);

        $conseil18 = new Conseil();
        $conseil18->setConseil("a");
        $conseil18->setTempAlerteSup(false);
        $conseil18->setTempAlerteInf(true);
        $conseil18->setHumAlerteSup(true);
        $conseil18->setHumAlerteInf(false);
        $conseil18->setCo2AlerteSup(true);
        $conseil18->setCo2AlerteInf(false);
        $conseil18->setTempSupOutside(false);
        $conseil18->setNoData(false);
        $manager->persist($conseil18);

        //2inferieur 1 supérieur
        $conseil19 = new Conseil();
        $conseil19->setConseil("a");
        $conseil19->setTempAlerteSup(true);
        $conseil19->setTempAlerteInf(false);
        $conseil19->setHumAlerteSup(false);
        $conseil19->setHumAlerteInf(true);
        $conseil19->setCo2AlerteSup(false);
        $conseil19->setCo2AlerteInf(true);
        $conseil19->setTempSupOutside(false);
        $conseil19->setNoData(false);
        $manager->persist($conseil19);


        $conseil20 = new Conseil();
        $conseil20->setConseil("a");
        $conseil20->setTempAlerteSup(false);
        $conseil20->setTempAlerteInf(true);
        $conseil20->setHumAlerteSup(true);
        $conseil20->setHumAlerteInf(false);
        $conseil20->setCo2AlerteSup(false);
        $conseil20->setCo2AlerteInf(true);
        $conseil20->setTempSupOutside(false);
        $conseil20->setNoData(false);
        $manager->persist($conseil20);


        $conseil21 = new Conseil();
        $conseil21->setConseil("a");
        $conseil21->setTempAlerteSup(false);
        $conseil21->setTempAlerteInf(true);
        $conseil21->setHumAlerteSup(false);
        $conseil21->setHumAlerteInf(true);
        $conseil21->setCo2AlerteSup(true);
        $conseil21->setCo2AlerteInf(false);
        $conseil21->setTempSupOutside(false);
        $conseil21->setNoData(false);
        $manager->persist($conseil21);

        //temperature bonne
        $conseil22 = new Conseil();
        $conseil22->setConseil("a");
        $conseil22->setTempAlerteSup(false);
        $conseil22->setTempAlerteInf(false);
        $conseil22->setHumAlerteSup(true);
        $conseil22->setHumAlerteInf(false);
        $conseil22->setCo2AlerteSup(true);
        $conseil22->setCo2AlerteInf(false);
        $conseil22->setTempSupOutside(false);
        $conseil22->setNoData(false);
        $manager->persist($conseil22);

        $conseil23 = new Conseil();
        $conseil23->setConseil("a");
        $conseil23->setTempAlerteSup(false);
        $conseil23->setTempAlerteInf(false);
        $conseil23->setHumAlerteSup(false);
        $conseil23->setHumAlerteInf(true);
        $conseil23->setCo2AlerteSup(false);
        $conseil23->setCo2AlerteInf(true);
        $conseil23->setTempSupOutside(false);
        $conseil23->setNoData(false);
        $manager->persist($conseil23);

        $conseil24 = new Conseil();
        $conseil24->setConseil("a");
        $conseil24->setTempAlerteSup(false);
        $conseil24->setTempAlerteInf(false);
        $conseil24->setHumAlerteSup(true);
        $conseil24->setHumAlerteInf(false);
        $conseil24->setCo2AlerteSup(false);
        $conseil24->setCo2AlerteInf(true);
        $conseil24->setTempSupOutside(false);
        $conseil24->setNoData(false);
        $manager->persist($conseil24);

        $conseil25 = new Conseil();
        $conseil25->setConseil("a");
        $conseil25->setTempAlerteSup(false);
        $conseil25->setTempAlerteInf(false);
        $conseil25->setHumAlerteSup(false);
        $conseil25->setHumAlerteInf(true);
        $conseil25->setCo2AlerteSup(true);
        $conseil25->setCo2AlerteInf(false);
        $conseil25->setTempSupOutside(false);
        $conseil25->setNoData(false);
        $manager->persist($conseil25);

        //humidite bonne
        $conseil26 = new Conseil();
        $conseil26->setConseil("a");
        $conseil26->setTempAlerteSup(true);
        $conseil26->setTempAlerteInf(false);
        $conseil26->setHumAlerteSup(false);
        $conseil26->setHumAlerteInf(false);
        $conseil26->setCo2AlerteSup(true);
        $conseil26->setCo2AlerteInf(false);
        $conseil26->setTempSupOutside(false);
        $conseil26->setNoData(false);
        $manager->persist($conseil26);

        $conseil27 = new Conseil();
        $conseil27->setConseil("a");
        $conseil27->setTempAlerteSup(false);
        $conseil27->setTempAlerteInf(true);
        $conseil27->setHumAlerteSup(false);
        $conseil27->setHumAlerteInf(false);
        $conseil27->setCo2AlerteSup(false);
        $conseil27->setCo2AlerteInf(true);
        $conseil27->setTempSupOutside(false);
        $conseil27->setNoData(false);
        $manager->persist($conseil27);


        $conseil28 = new Conseil();
        $conseil28->setConseil("a");
        $conseil28->setTempAlerteSup(true);
        $conseil28->setTempAlerteInf(false);
        $conseil28->setHumAlerteSup(false);
        $conseil28->setHumAlerteInf(false);
        $conseil28->setCo2AlerteSup(false);
        $conseil28->setCo2AlerteInf(true);
        $conseil28->setTempSupOutside(false);
        $conseil28->setNoData(false);
        $manager->persist($conseil28);


        $conseil29 = new Conseil();
        $conseil29->setConseil("a");
        $conseil29->setTempAlerteSup(false);
        $conseil29->setTempAlerteInf(true);
        $conseil29->setHumAlerteSup(false);
        $conseil29->setHumAlerteInf(false);
        $conseil29->setCo2AlerteSup(true);
        $conseil29->setCo2AlerteInf(false);
        $conseil29->setTempSupOutside(false);
        $conseil29->setNoData(false);
        $manager->persist($conseil29);

        //co2 bon
        $conseil30 = new Conseil();
        $conseil30->setConseil("a");
        $conseil30->setTempAlerteSup(true);
        $conseil30->setTempAlerteInf(false);
        $conseil30->setHumAlerteSup(true);
        $conseil30->setHumAlerteInf(false);
        $conseil30->setCo2AlerteSup(false);
        $conseil30->setCo2AlerteInf(false);
        $conseil30->setTempSupOutside(false);
        $conseil30->setNoData(false);
        $manager->persist($conseil30);

        $conseil31 = new Conseil();
        $conseil31->setConseil("a");
        $conseil31->setTempAlerteSup(false);
        $conseil31->setTempAlerteInf(true);
        $conseil31->setHumAlerteSup(false);
        $conseil31->setHumAlerteInf(true);
        $conseil31->setCo2AlerteSup(false);
        $conseil31->setCo2AlerteInf(false);
        $conseil31->setTempSupOutside(false);
        $conseil31->setNoData(false);
        $manager->persist($conseil31);

        $conseil32 = new Conseil();
        $conseil32->setConseil("Ouvrez les fenetres et les portes pour faire circuler l'air");
        $conseil32->setTempAlerteSup(true);
        $conseil32->setTempAlerteInf(false);
        $conseil32->setHumAlerteSup(false);
        $conseil32->setHumAlerteInf(true);
        $conseil32->setCo2AlerteSup(false);
        $conseil32->setCo2AlerteInf(false);
        $conseil32->setTempSupOutside(false);
        $conseil32->setNoData(false);
        $manager->persist($conseil32);

        $conseil33 = new Conseil();
        $conseil33->setConseil("a");
        $conseil33->setTempAlerteSup(false);
        $conseil33->setTempAlerteInf(true);
        $conseil33->setHumAlerteSup(true);
        $conseil33->setHumAlerteInf(false);
        $conseil33->setCo2AlerteSup(false);
        $conseil33->setCo2AlerteInf(false);
        $conseil33->setTempSupOutside(false);
        $conseil33->setNoData(false);
        $manager->persist($conseil33);

//les memes conseils mais il fait plus chaud dehors

        //alerte unitaire
        $conseil35 = new Conseil();
        $conseil35->setConseil("Ouvrez les fenetres et les portes pour faire circuler l'air");
        $conseil35->setTempAlerteSup(true);
        $conseil35->setTempAlerteInf(false);
        $conseil35->setHumAlerteSup(false);
        $conseil35->setHumAlerteInf(false);
        $conseil35->setCo2AlerteSup(false);
        $conseil35->setCo2AlerteInf(false);
        $conseil35->setTempSupOutside(true);
        $conseil35->setNoData(false);
        $manager->persist($conseil35);

        $conseil36 = new Conseil();
        $conseil36->setConseil("aide 2");
        $conseil36->setTempAlerteSup(false);
        $conseil36->setTempAlerteInf(true);
        $conseil36->setHumAlerteSup(false);
        $conseil36->setHumAlerteInf(false);
        $conseil36->setCo2AlerteSup(false);
        $conseil36->setCo2AlerteInf(false);
        $conseil36->setTempSupOutside(true);
        $conseil36->setNoData(false);
        $manager->persist($conseil36);

        $conseil37 = new Conseil();
        $conseil37->setConseil("aide 3");
        $conseil37->setTempAlerteSup(false);
        $conseil37->setTempAlerteInf(false);
        $conseil37->setHumAlerteSup(true);
        $conseil37->setHumAlerteInf(false);
        $conseil37->setCo2AlerteSup(false);
        $conseil37->setCo2AlerteInf(false);
        $conseil37->setTempSupOutside(true);
        $conseil37->setNoData(false);
        $manager->persist($conseil37);

        $conseil38 = new Conseil();
        $conseil38->setConseil("augmentez la température");
        $conseil38->setTempAlerteSup(false);
        $conseil38->setTempAlerteInf(false);
        $conseil38->setHumAlerteSup(false);
        $conseil38->setHumAlerteInf(true);
        $conseil38->setCo2AlerteSup(false);
        $conseil38->setCo2AlerteInf(false);
        $conseil38->setTempSupOutside(true);
        $conseil38->setNoData(false);
        $manager->persist($conseil38);

        $conseil39 = new Conseil();
        $conseil39->setConseil("augmentez la température");
        $conseil39->setTempAlerteSup(false);
        $conseil39->setTempAlerteInf(false);
        $conseil39->setHumAlerteSup(false);
        $conseil39->setHumAlerteInf(false);
        $conseil39->setCo2AlerteSup(true);
        $conseil39->setCo2AlerteInf(false);
        $conseil39->setTempSupOutside(true);
        $conseil39->setNoData(false);
        $manager->persist($conseil39);

        $conseil40 = new Conseil();
        $conseil40->setConseil("augmentez la température");
        $conseil40->setTempAlerteSup(false);
        $conseil40->setTempAlerteInf(false);
        $conseil40->setHumAlerteSup(false);
        $conseil40->setHumAlerteInf(false);
        $conseil40->setCo2AlerteSup(false);
        $conseil40->setCo2AlerteInf(true);
        $conseil40->setTempSupOutside(true);
        $conseil40->setNoData(false);
        $manager->persist($conseil40);


        //toute les alertes superieures ensemble
        $conseil41 = new Conseil();
        $conseil41->setConseil("aide 8");
        $conseil41->setTempAlerteSup(true);
        $conseil41->setTempAlerteInf(false);
        $conseil41->setHumAlerteSup(true);
        $conseil41->setHumAlerteInf(false);
        $conseil41->setCo2AlerteSup(false);
        $conseil41->setCo2AlerteInf(false);
        $conseil41->setTempSupOutside(true);
        $conseil41->setNoData(false);
        $manager->persist($conseil41);

        $conseil42 = new Conseil();
        $conseil42->setConseil("aide 9");
        $conseil42->setTempAlerteSup(true);
        $conseil42->setTempAlerteInf(false);
        $conseil42->setHumAlerteSup(false);
        $conseil42->setHumAlerteInf(false);
        $conseil42->setCo2AlerteSup(true);
        $conseil42->setCo2AlerteInf(false);
        $conseil42->setTempSupOutside(true);
        $conseil42->setNoData(false);
        $manager->persist($conseil42);

        $conseil43 = new Conseil();
        $conseil43->setConseil("aide 10");
        $conseil43->setTempAlerteSup(false);
        $conseil43->setTempAlerteInf(false);
        $conseil43->setHumAlerteSup(true);
        $conseil43->setHumAlerteInf(false);
        $conseil43->setCo2AlerteSup(true);
        $conseil43->setCo2AlerteInf(false);
        $conseil43->setTempSupOutside(true);
        $conseil43->setNoData(false);
        $manager->persist($conseil43);

        $conseil44 = new Conseil();
        $conseil44->setConseil("augmentez la température");
        $conseil44->setTempAlerteSup(true);
        $conseil44->setTempAlerteInf(false);
        $conseil44->setHumAlerteSup(true);
        $conseil44->setHumAlerteInf(false);
        $conseil44->setCo2AlerteSup(true);
        $conseil44->setCo2AlerteInf(false);
        $conseil44->setTempSupOutside(true);
        $conseil44->setNoData(false);
        $manager->persist($conseil44);

        //toute les alertes inférieurs ensemble

        $conseil45 = new Conseil();
        $conseil45->setConseil("a");
        $conseil45->setTempAlerteSup(false);
        $conseil45->setTempAlerteInf(true);
        $conseil45->setHumAlerteSup(false);
        $conseil45->setHumAlerteInf(false);
        $conseil45->setCo2AlerteSup(false);
        $conseil45->setCo2AlerteInf(true);
        $conseil45->setTempSupOutside(true);
        $conseil45->setNoData(false);
        $manager->persist($conseil45);

        $conseil46 = new Conseil();
        $conseil46->setConseil("a");
        $conseil46->setTempAlerteSup(false);
        $conseil46->setTempAlerteInf(true);
        $conseil46->setHumAlerteSup(false);
        $conseil46->setHumAlerteInf(true);
        $conseil46->setCo2AlerteSup(false);
        $conseil46->setCo2AlerteInf(false);
        $conseil46->setTempSupOutside(true);
        $conseil46->setNoData(false);
        $manager->persist($conseil46);

        $conseil47 = new Conseil();
        $conseil47->setConseil("a");
        $conseil47->setTempAlerteSup(false);
        $conseil47->setTempAlerteInf(false);
        $conseil47->setHumAlerteSup(false);
        $conseil47->setHumAlerteInf(true);
        $conseil47->setCo2AlerteSup(false);
        $conseil47->setCo2AlerteInf(true);
        $conseil47->setTempSupOutside(true);
        $conseil47->setNoData(false);
        $manager->persist($conseil47);

        $conseil48 = new Conseil();
        $conseil48->setConseil("a");
        $conseil48->setTempAlerteSup(false);
        $conseil48->setTempAlerteInf(true);
        $conseil48->setHumAlerteSup(false);
        $conseil48->setHumAlerteInf(true);
        $conseil48->setCo2AlerteSup(false);
        $conseil48->setCo2AlerteInf(true);
        $conseil48->setTempSupOutside(true);
        $conseil48->setNoData(false);
        $manager->persist($conseil48);

        //2 superieur 1 inferieur
        $conseil49 = new Conseil();
        $conseil49->setConseil("a");
        $conseil49->setTempAlerteSup(true);
        $conseil49->setTempAlerteInf(false);
        $conseil49->setHumAlerteSup(true);
        $conseil49->setHumAlerteInf(false);
        $conseil49->setCo2AlerteSup(false);
        $conseil49->setCo2AlerteInf(true);
        $conseil49->setTempSupOutside(true);
        $conseil49->setNoData(false);
        $manager->persist($conseil49);

        $conseil50 = new Conseil();
        $conseil50->setConseil("a");
        $conseil50->setTempAlerteSup(true);
        $conseil50->setTempAlerteInf(false);
        $conseil50->setHumAlerteSup(false);
        $conseil50->setHumAlerteInf(true);
        $conseil50->setCo2AlerteSup(true);
        $conseil50->setCo2AlerteInf(false);
        $conseil50->setTempSupOutside(true);
        $conseil50->setNoData(false);
        $manager->persist($conseil50);

        $conseil51 = new Conseil();
        $conseil51->setConseil("a");
        $conseil51->setTempAlerteSup(false);
        $conseil51->setTempAlerteInf(true);
        $conseil51->setHumAlerteSup(true);
        $conseil51->setHumAlerteInf(false);
        $conseil51->setCo2AlerteSup(true);
        $conseil51->setCo2AlerteInf(false);
        $conseil51->setTempSupOutside(true);
        $conseil51->setNoData(false);
        $manager->persist($conseil51);

        //2inferieur 1 supérieur
        $conseil52 = new Conseil();
        $conseil52->setConseil("a");
        $conseil52->setTempAlerteSup(true);
        $conseil52->setTempAlerteInf(false);
        $conseil52->setHumAlerteSup(false);
        $conseil52->setHumAlerteInf(true);
        $conseil52->setCo2AlerteSup(false);
        $conseil52->setCo2AlerteInf(true);
        $conseil52->setTempSupOutside(true);
        $conseil52->setNoData(false);
        $manager->persist($conseil52);


        $conseil53 = new Conseil();
        $conseil53->setConseil("a");
        $conseil53->setTempAlerteSup(false);
        $conseil53->setTempAlerteInf(true);
        $conseil53->setHumAlerteSup(true);
        $conseil53->setHumAlerteInf(false);
        $conseil53->setCo2AlerteSup(false);
        $conseil53->setCo2AlerteInf(true);
        $conseil53->setTempSupOutside(true);
        $conseil53->setNoData(false);
        $manager->persist($conseil53);


        $conseil54 = new Conseil();
        $conseil54->setConseil("a");
        $conseil54->setTempAlerteSup(false);
        $conseil54->setTempAlerteInf(true);
        $conseil54->setHumAlerteSup(false);
        $conseil54->setHumAlerteInf(true);
        $conseil54->setCo2AlerteSup(true);
        $conseil54->setCo2AlerteInf(false);
        $conseil54->setTempSupOutside(true);
        $conseil54->setNoData(false);
        $manager->persist($conseil54);

        //temperature bonne
        $conseil55 = new Conseil();
        $conseil55->setConseil("a");
        $conseil55->setTempAlerteSup(false);
        $conseil55->setTempAlerteInf(false);
        $conseil55->setHumAlerteSup(true);
        $conseil55->setHumAlerteInf(false);
        $conseil55->setCo2AlerteSup(true);
        $conseil55->setCo2AlerteInf(false);
        $conseil55->setTempSupOutside(true);
        $conseil55->setNoData(false);
        $manager->persist($conseil55);

        $conseil56 = new Conseil();
        $conseil56->setConseil("a");
        $conseil56->setTempAlerteSup(false);
        $conseil56->setTempAlerteInf(false);
        $conseil56->setHumAlerteSup(false);
        $conseil56->setHumAlerteInf(true);
        $conseil56->setCo2AlerteSup(false);
        $conseil56->setCo2AlerteInf(true);
        $conseil56->setTempSupOutside(true);
        $conseil56->setNoData(false);
        $manager->persist($conseil56);

        $conseil57 = new Conseil();
        $conseil57->setConseil("a");
        $conseil57->setTempAlerteSup(false);
        $conseil57->setTempAlerteInf(false);
        $conseil57->setHumAlerteSup(true);
        $conseil57->setHumAlerteInf(false);
        $conseil57->setCo2AlerteSup(false);
        $conseil57->setCo2AlerteInf(true);
        $conseil57->setTempSupOutside(true);
        $conseil57->setNoData(false);
        $manager->persist($conseil57);

        $conseil58 = new Conseil();
        $conseil58->setConseil("a");
        $conseil58->setTempAlerteSup(false);
        $conseil58->setTempAlerteInf(false);
        $conseil58->setHumAlerteSup(false);
        $conseil58->setHumAlerteInf(true);
        $conseil58->setCo2AlerteSup(true);
        $conseil58->setCo2AlerteInf(false);
        $conseil58->setTempSupOutside(true);
        $conseil58->setNoData(false);
        $manager->persist($conseil58);

        //humidite bonne
        $conseil59 = new Conseil();
        $conseil59->setConseil("a");
        $conseil59->setTempAlerteSup(true);
        $conseil59->setTempAlerteInf(false);
        $conseil59->setHumAlerteSup(false);
        $conseil59->setHumAlerteInf(false);
        $conseil59->setCo2AlerteSup(true);
        $conseil59->setCo2AlerteInf(false);
        $conseil59->setTempSupOutside(true);
        $conseil59->setNoData(false);
        $manager->persist($conseil59);

        $conseil60 = new Conseil();
        $conseil60->setConseil("a");
        $conseil60->setTempAlerteSup(false);
        $conseil60->setTempAlerteInf(true);
        $conseil60->setHumAlerteSup(false);
        $conseil60->setHumAlerteInf(false);
        $conseil60->setCo2AlerteSup(false);
        $conseil60->setCo2AlerteInf(true);
        $conseil60->setTempSupOutside(true);
        $conseil60->setNoData(false);
        $manager->persist($conseil60);


        $conseil61 = new Conseil();
        $conseil61->setConseil("a");
        $conseil61->setTempAlerteSup(true);
        $conseil61->setTempAlerteInf(false);
        $conseil61->setHumAlerteSup(false);
        $conseil61->setHumAlerteInf(false);
        $conseil61->setCo2AlerteSup(false);
        $conseil61->setCo2AlerteInf(true);
        $conseil61->setTempSupOutside(true);
        $conseil61->setNoData(false);
        $manager->persist($conseil61);


        $conseil62 = new Conseil();
        $conseil62->setConseil("a");
        $conseil62->setTempAlerteSup(false);
        $conseil62->setTempAlerteInf(true);
        $conseil62->setHumAlerteSup(false);
        $conseil62->setHumAlerteInf(false);
        $conseil62->setCo2AlerteSup(true);
        $conseil62->setCo2AlerteInf(false);
        $conseil62->setTempSupOutside(true);
        $conseil62->setNoData(false);
        $manager->persist($conseil62);

        //co2 bon
        $conseil63 = new Conseil();
        $conseil63->setConseil("a");
        $conseil63->setTempAlerteSup(true);
        $conseil63->setTempAlerteInf(false);
        $conseil63->setHumAlerteSup(true);
        $conseil63->setHumAlerteInf(false);
        $conseil63->setCo2AlerteSup(false);
        $conseil63->setCo2AlerteInf(false);
        $conseil63->setTempSupOutside(true);
        $conseil63->setNoData(false);
        $manager->persist($conseil63);

        $conseil64 = new Conseil();
        $conseil64->setConseil("a");
        $conseil64->setTempAlerteSup(false);
        $conseil64->setTempAlerteInf(true);
        $conseil64->setHumAlerteSup(false);
        $conseil64->setHumAlerteInf(true);
        $conseil64->setCo2AlerteSup(false);
        $conseil64->setCo2AlerteInf(false);
        $conseil64->setTempSupOutside(true);
        $conseil64->setNoData(false);
        $manager->persist($conseil64);

        $conseil65 = new Conseil();
        $conseil65->setConseil("Ouvrez les fenetres et les portes pour faire circuler l'air");
        $conseil65->setTempAlerteSup(true);
        $conseil65->setTempAlerteInf(false);
        $conseil65->setHumAlerteSup(false);
        $conseil65->setHumAlerteInf(true);
        $conseil65->setCo2AlerteSup(false);
        $conseil65->setCo2AlerteInf(false);
        $conseil65->setTempSupOutside(true);
        $conseil65->setNoData(false);
        $manager->persist($conseil65);

        $conseil66 = new Conseil();
        $conseil66->setConseil("a");
        $conseil66->setTempAlerteSup(false);
        $conseil66->setTempAlerteInf(true);
        $conseil66->setHumAlerteSup(true);
        $conseil66->setHumAlerteInf(false);
        $conseil66->setCo2AlerteSup(false);
        $conseil66->setCo2AlerteInf(false);
        $conseil66->setTempSupOutside(true);
        $conseil66->setNoData(false);
        $manager->persist($conseil66);

        $manager->flush();
    }
}
