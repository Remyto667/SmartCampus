<?php

namespace App\Entity;

use App\Domain\Alert;
use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[UniqueEntity(
    fields : 'name',
    message: 'Ce nom est déjà utilisé',
)]
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

    #[ORM\Column]
    private ?int $room_size = null;

    #[ORM\Column]
    private ?int $windows_number = null;

    #[ORM\Column(length: 3)]
    private ?string $orientation = null;

    #[ORM\Column]
    private ?int $floor = null;

    private bool $isAlert;

    /**
     * @return bool
     */

    public function getIsAlert() : bool
    {
        return $this->isAlert;
    }

    /**
     * @param bool $isAlert
     */
    public function setIsAlert(bool $isAlert): void
    {
        $this->isAlert = $isAlert;
    }

    #[ORM\ManyToOne(inversedBy: 'room')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;


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


    public function isIsStock(): ?bool
    {
        return $this->isStock;
    }

    public function setIsStock(?bool $isStock): self
    {
        $this->isStock = $isStock;

        return $this;
    }

    public function getRoomSize(): ?int
    {
        return $this->room_size;
    }

    public function setRoomSize(int $room_size): self
    {
        $this->room_size = $room_size;

        return $this;
    }

    public function getWindowsNumber(): ?int
    {
        return $this->windows_number;
    }

    public function setWindowsNumber(int $windows_number): self
    {
        $this->windows_number = $windows_number;

        return $this;
    }


    public function getType(): ?Type
    {
        return $this->type;
    }

    public function getTypeString(): ?string
    {
        $type = "";
        if ($this->type->getId() == 0){
            $type = "Bureau";
        }
        elseif ($this->type->getId() == 1) {
            $type = "Salle de classe";
        }
        elseif ($this->type->getId() == 2) {
            $type = "Serveur";
        }
        elseif ($this->type->getId() == 3) {
            $type = "Secrétariat";
        }
        elseif ($this->type->getId() == 4) {
            $type = "Autres";
        }
        return $type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function getOrientationString(): ?string
    {
        if ($this->orientation == "N") {
            $orientation = "Nord";
        }
        elseif ($this->orientation == "S") {
            $orientation = "Sud";
        }
        elseif ($this->orientation == "E") {
            $orientation = "Est";
        }
        elseif ($this->orientation == "O") {
            $orientation = "Ouest";
        }
        else {
            $orientation = "orientation non valide";
        }
        return $orientation;
    }

    public function setOrientation(string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

}
