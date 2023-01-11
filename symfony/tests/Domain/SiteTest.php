<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
class AdminControllerTest extends WebTestCase
{
    public function test_page_selection()
    {
        // Arrange
        $client = static::createClient();
        // Act
        $client->request('GET', '/accueil');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /*public function test_page_avec_authentification()
    {
        // Arrange
        $client = static::createClient();
        // Act
        $token = new UsernamePasswordToken('technicien', 'technicien', 'ROLE_TECH', array('ROLE_USER'));
        $session = static::$kernel->getContainer()->get('session');
        $session->set('_security_secured_area', serialize($token));
        $session->save();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));
        $client->request('GET', '/admin/profil');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }*/

}

