<?php

namespace App\Entity;

use App\Repository\ConseilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConseilRepository::class)]
class Conseil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $conseil = null;

    #[ORM\Column]
    private ?bool $temp_alerte_sup = null;

    #[ORM\Column]
    private ?bool $temp_alerte_inf = null;

    #[ORM\Column]
    private ?bool $hum_alerte_sup = null;

    #[ORM\Column]
    private ?bool $hum_alerte_inf = null;

    #[ORM\Column]
    private ?bool $co2_alerte_sup = null;

    #[ORM\Column]
    private ?bool $co2_alerte_inf = null;

    #[ORM\Column]
    private ?bool $temp_sup_outside = null;

    #[ORM\Column]
    private ?bool $no_data = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConseil(): ?string
    {
        return $this->conseil;
    }

    public function setConseil(string $conseil): self
    {
        $this->conseil = $conseil;

        return $this;
    }

    public function isTempAlerteSup(): ?bool
    {
        return $this->temp_alerte_sup;
    }

    public function setTempAlerteSup(bool $temp_alerte_sup): self
    {
        $this->temp_alerte_sup = $temp_alerte_sup;

        return $this;
    }

    public function isTempAlerteInf(): ?bool
    {
        return $this->temp_alerte_inf;
    }

    public function setTempAlerteInf(bool $temp_alerte_inf): self
    {
        $this->temp_alerte_inf = $temp_alerte_inf;

        return $this;
    }

    public function isHumAlerteSup(): ?bool
    {
        return $this->hum_alerte_sup;
    }

    public function setHumAlerteSup(bool $hum_alerte_sup): self
    {
        $this->hum_alerte_sup = $hum_alerte_sup;

        return $this;
    }

    public function isHumAlerteInf(): ?bool
    {
        return $this->hum_alerte_inf;
    }

    public function setHumAlerteInf(bool $hum_alerte_inf): self
    {
        $this->hum_alerte_inf = $hum_alerte_inf;

        return $this;
    }

    public function isCo2AlerteSup(): ?bool
    {
        return $this->co2_alerte_sup;
    }

    public function setCo2AlerteSup(bool $co2_alerte_sup): self
    {
        $this->co2_alerte_sup = $co2_alerte_sup;

        return $this;
    }

    public function isCo2AlerteInf(): ?bool
    {
        return $this->co2_alerte_inf;
    }

    public function setCo2AlerteInf(bool $co2_alerte_inf): self
    {
        $this->co2_alerte_inf = $co2_alerte_inf;

        return $this;
    }

    public function isTempSupOutside(): ?bool
    {
        return $this->temp_sup_outside;
    }

    public function setTempSupOutside(bool $temp_sup_outside): self
    {
        $this->temp_sup_outside = $temp_sup_outside;

        return $this;
    }

    public function isNoData(): ?bool
    {
        return $this->no_data;
    }

    public function getNoData(): ?bool
    {
        return (string)$this->no_data;
    }

    public function setNoData(bool $no_data): self
    {
        $this->no_data = $no_data;

        return $this;
    }
}
