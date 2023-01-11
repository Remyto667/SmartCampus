<?php

namespace App\Tests\Domain;

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
        $type->setCo2Max("800");
        $type->setCo2Min("400");
        $type->setHumMax("60");
        $type->setHumMin("40");
        $type->setTempMax("22");
        $type->setTempMin("19");


        $room=new Room;
        $room->setName("D280");
        $room->setFloor(1);
        $room->setIsStock(false);
        $room->setOrientation("N");
        $room->setType($type);
        $room->setRoomSize("42");
        $room->setWindowsNumber("5");

        $this->assertEquals("D280",$room->getName());
        $this->assertEquals(1,$room->getFloor());
        $this->assertEquals("N",$room->getOrientation());
        $this->assertEquals($type,$room->getType());
        $this->assertEquals("42",$room->getRoomSize());
        $this->assertEquals("5",$room->getWindowsNumber());
    }

    public function test_system()
    {
        $type = new Type();
        $type->setName("Salle");
        $type->setCo2Max("800");
        $type->setCo2Min("400");
        $type->setHumMax("60");
        $type->setHumMin("40");
        $type->setTempMax("22");
        $type->setTempMin("19");

        $room = new Room;
        $room->setName("D280");
        $room->setFloor(1);
        $room->setIsStock(false);
        $room->setOrientation("N");
        $room->setType($type);
        $room->setRoomSize("42");
        $room->setWindowsNumber("5");

        $system = new System();
        $system->setName("system1");
        $system->setRoom($room);
        $system->setTag("12");

        $this->assertEquals("system1",$system->getName());
        $this->assertEquals("12",$system->getTag());
        $this->assertEquals($room,$system->getRoom());
    }

    public function test_sensor()
    {
        $type = new Type();
        $type->setName("Salle");
        $type->setCo2Max("800");
        $type->setCo2Min("400");
        $type->setHumMax("60");
        $type->setHumMin("40");
        $type->setTempMax("22");
        $type->setTempMin("19");

        $room = new Room;
        $room->setName("D280");
        $room->setFloor(1);
        $room->setIsStock(false);
        $room->setOrientation("N");
        $room->setType($type);
        $room->setRoomSize("42");
        $room->setWindowsNumber("5");

        $system = new System();
        $system->setName("system1");
        $system->setRoom($room);
        $system->setTag("12");

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
}