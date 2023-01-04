<?php

namespace App\Domain\Query;

use App\Domain\DonneesCapteurs;

class DonneesCapteursHandler
{
    private $donneesCapteurs;

    public function __construct(DonneesCapteurs $donneesCapteurs)
    {
        $this->donneesCapteurs = $donneesCapteurs;
    }

    public function handle(DonneesCapteursQuery $requete)
    {
        return $this->donneesCapteurs->getDonneesPourSalle($requete->getTag());
    }
}