<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $tempMax = null;

    #[ORM\Column]
    private ?int $tempMin = null;

    #[ORM\Column]
    private ?int $humMax = null;

    #[ORM\Column]
    private ?int $humMin = null;

    #[ORM\Column]
    private ?int $co2Max = null;

    #[ORM\Column]
    private ?int $co2Min = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Room::class)]
    private Collection $room;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->room = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTempMax(): ?int
    {
        return $this->tempMax;
    }

    public function setTempMax(int $tempMax): self
    {
        $this->tempMax = $tempMax;

        return $this;
    }

    public function getTempMin(): ?int
    {
        return $this->tempMin;
    }

    public function setTempMin(int $tempMin): self
    {
        $this->tempMin = $tempMin;

        return $this;
    }

    public function getHumMax(): ?int
    {
        return $this->humMax;
    }

    public function setHumMax(int $humMax): self
    {
        $this->humMax = $humMax;

        return $this;
    }

    public function getHumMin(): ?int
    {
        return $this->humMin;
    }

    public function setHumMin(int $humMin): self
    {
        $this->humMin = $humMin;

        return $this;
    }

    public function getCo2Max(): ?int
    {
        return $this->co2Max;
    }

    public function setCo2Max(int $co2Max): self
    {
        $this->co2Max = $co2Max;

        return $this;
    }

    public function getCo2Min(): ?int
    {
        return $this->co2Min;
    }

    public function setCo2Min(int $co2Min): self
    {
        $this->co2Min = $co2Min;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->room->contains($room)) {
            $this->room->add($room);
            $room->setType($this);
        }
        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->room->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getType() === $this) {
                $room->setType(null);
            }
        }
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
