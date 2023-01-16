<?php

namespace App\Tests\Domain;

use App\Entity\Conseil;
use App\Entity\Room;
use App\Entity\Sensor;
use App\Entity\System;
use App\Entity\Type;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    public function test_room(){
        $type =new Type();
        $type->setName("Salle");
        $type->setCo2Max(800);
        $type->setCo2Min(400);
        $type->setHumMax(60);
        $type->setHumMin(40);
        $type->setTempMax(22);
        $type->setTempMin(19);


        $room=new Room;
        $room->setName("D280");
        $room->setFloor(1);
        $room->setIsStock(false);
        $room->setOrientation("N");
        $room->setType($type);
        $room->setRoomSize(42);
        $room->setWindowsNumber(5);

        $this->assertEquals("D280",$room->getName());
        $this->assertEquals(1,$room->getFloor());
        $this->assertEquals("N",$room->getOrientation());
        $this->assertEquals($type,$room->getType());
        $this->assertEquals(42,$room->getRoomSize());
        $this->assertEquals(5,$room->getWindowsNumber());
    }

    public function test_system()
    {
        $type = new Type();
        $type->setName("Salle");
        $type->setCo2Max(800);
        $type->setCo2Min(400);
        $type->setHumMax(60);
        $type->setHumMin(40);
        $type->setTempMax(22);
        $type->setTempMin(19);

        $room = new Room;
        $room->setName("D280");
        $room->setFloor(1);
        $room->setIsStock(false);
        $room->setOrientation("N");
        $room->setType($type);
        $room->setRoomSize(42);
        $room->setWindowsNumber(5);

        $system = new System();
        $system->setName("system1");
        $system->setRoom($room);
        $system->setTag(12);

        $this->assertEquals("system1",$system->getName());
        $this->assertEquals(12,$system->getTag());
        $this->assertEquals($room,$system->getRoom());
    }

    public function test_sensor()
    {
        $type = new Type();
        $type->setName("Salle");
        $type->setCo2Max(800);
        $type->setCo2Min(400);
        $type->setHumMax(60);
        $type->setHumMin(40);
        $type->setTempMax(22);
        $type->setTempMin(19);

        $room = new Room;
        $room->setName("D280");
        $room->setFloor(1);
        $room->setIsStock(false);
        $room->setOrientation("N");
        $room->setType($type);
        $room->setRoomSize(42);
        $room->setWindowsNumber(5);

        $system = new System();
        $system->setName("system1");
        $system->setRoom($room);
        $system->setTag(12);

        $sensor = new Sensor();
        $sensor->setName("sensor1");
        $sensor->setType("temperature");
        $sensor->setState("fonctionnel");
        $sensor->setSystems($system);

        $this->assertEquals("sensor1",$sensor->getName());
        $this->assertEquals("temperature",$sensor->getType());
        $this->assertEquals("fonctionnel",$sensor->getState());
        $this->assertEquals($system,$sensor->getSystems());
    }

    public function test_conseil()
    {
        $conseil = new Conseil();
        $conseil->setConseil("Ceci est un conseil");
        $conseil->setTempAlerteSup(false);
        $conseil->setTempAlerteInf(false);
        $conseil->setHumAlerteSup(false);
        $conseil->setHumAlerteInf(false);
        $conseil->setCo2AlerteSup(false);
        $conseil->setCo2AlerteInf(false);
        $conseil->setTempSupOutside(false);
        $conseil->setNoData(false);



        $this->assertEquals("Ceci est un conseil",$conseil->getConseil());
        $this->assertEquals(false,$conseil->isTempAlerteSup());
        $this->assertEquals(false,$conseil->isTempAlerteInf());
        $this->assertEquals(false,$conseil->isHumAlerteSup());
        $this->assertEquals(false,$conseil->isHumAlerteInf());
        $this->assertEquals(false,$conseil->isCo2AlerteSup());
        $this->assertEquals(false,$conseil->isCo2AlerteInf());
        $this->assertEquals(false,$conseil->isTempSupOutside());
        $this->assertEquals(false,$conseil->isNoData());
    }

    public function test_type()
    {
        $type = new Type();
        $type->setName("Chambre");
        $type->setTempMax(21);
        $type->setTempMin(19);
        $type->setHumMax(60);
        $type->setHumMin(40);
        $type->setCo2Max(800);
        $type->setCo2Min(400);

        $this->assertEquals("Chambre",$type->getName());
        $this->assertEquals(21,$type->getTempMax());
        $this->assertEquals(19,$type->getTempMin());
        $this->assertEquals(60,$type->getHumMax());
        $this->assertEquals(40,$type->getHumMin());
        $this->assertEquals(800,$type->getCo2Max());
        $this->assertEquals(400,$type->getCo2Min());
    }

/*
    public function test_lister_les_films_a_l_affiche_sollicite_le_programme(){
        // Arrange
        $cinema =$this->createMock(Cinema::class);
        $query = new ProgrammationCinemaQuery($cinema);
        $programme=$this->createMock(ProgrammeDeCinema::class);
        // Assert (préparation)
        $programme->expects($this->once())->method("getFilmsPourCinema");
        //Arrange
        $handler=new ProgrammationCinemaHandler($programme);
        //Act
        $resultat=$handler->handle($query);
        //Assert
        $this->assertIsIterable($resultat);
        }
*/
}