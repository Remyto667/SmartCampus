<?php
// tests/Domain/CinemaTest.php
/*
La convention pour les tests est que le répertoire des tests reflète la hiérarchie du
code. Nous nous positions donc dans un répertoire “Domain” pour bien
identifier que nous sommes en train de faire notre modèle de domaine, et
pas de la “plomberie technique”.
*/
namespace App\Domain;
use PHPUnit\Framework\TestCase;

class CinemaTest extends TestCase
{
    public function test_un_cinema_expose_son_nom(){
        $cinema=new Cinema("Le Lafayette");
        $this->assertEquals("Le Lafayette",$cinema->getNom());
    }
}
