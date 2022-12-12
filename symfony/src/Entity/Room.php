<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[UniqueEntity(
    fields : 'name',
    message: 'Ce nom est déjà utilisé',)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(
        message: 'Le nom de votre salle doit faire entre 1 et 5 caractères',
    )]
    #[Assert\Length(
        min: 1,
        max: 5,
        minMessage: 'Le nom de votre salle doit faire entre 1 et 5 caractères',
        maxMessage: 'Le nom de votre salle doit faire entre 1 et 5 caractères',
    )]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isStock = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function addRoom(Room $room): self
    {
        if (!$this->room->contains($room)) {
            $this->room->add($room);
            $room->setRooms($this);
        }

        return $this;
    }
    public function removeRoom(Room $room): self
    {
        if ($this->room->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getRooms() === $this) {
                $room->setRooms(null);
            }
        }

        return $this;
    }

    public function isIsStock(): ?bool
    {
        return $this->isStock;
    }

    public function setIsStock(?bool $isStock): self
    {
        $this->isStock = $isStock;

        return $this;
    }
}
