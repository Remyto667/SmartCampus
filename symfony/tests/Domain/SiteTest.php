<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
class AdminControllerTest extends WebTestCase
{
    public function test_page_accueil()
    {
        // Arrange
        $client = static::createClient();
        // Act
        $client->request('GET', '/accueil');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    /*
         * il va chercher la base sae-test au lieu de la base sae (a changer dans les fichiers mais jsp ou)
         */

    public function test_page_liste_salles()
    {
        /*
        // Arrange
        $client = static::createClient();
        // Act
        $client->request('GET', '/inventaire/lister_salles');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        */
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/profil');
        $this->assertResponseIsSuccessful();
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

