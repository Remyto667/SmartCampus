<?php
namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
class AdminControllerTest extends WebTestCase
{
    // ACCEUIL
    public function test_page_accueil()
    {
        // Arrange
        $client = static::createClient();
        // Act
        $client->request('GET', '/accueil');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    //PAGE DE CONNEXION
    public function test_page_connexion()
    {
        // Arrange
        $client = static::createClient();
        // Act
        $client->request('GET', '/login');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    //PAGE DISPONIBLE POUR LES ADMINS ET TECHNICIEN

    public function test_page_profil()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/profil');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_liste_salles()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/inventaire/lister_salles');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_liste_capteurs()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/inventaire/lister_capteurs');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_liste_systemes()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/inventaire/lister_systemes');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_ajouter_salles()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/inventaire/ajouter_salle');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_ajouter_systemes()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/inventaire/ajouter_systeme');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_ajouter_capteurs()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/inventaire/ajouter_capteur');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_alerte_selection()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/alerte_selection');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_selection()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/selection_salle');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_suivi_selection()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/suivi/selection_salle');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_donnees_salle_admin()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/donnees_salle_admin/2');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_alerte_stat()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/alerte_vision/1');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_graphique()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/suivi/graphique/7');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_guide()
    {
        $client = static::createClient();

        // Connexion a un technicien
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'technicien']);

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/admin/guide');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    //DISPONIBLE POUR TOUT LES UTILISATEURS

    public function test_page_salles()
    {
        // Arrange
        $client = static::createClient();
        // Act
        $client->request('GET', '/salle/3');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_page_salles_selection_utilisateur()
    {
        // Arrange
        $client = static::createClient();
        // Act
        $client->request('GET', '/salle/selection');
        // Assert
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}

