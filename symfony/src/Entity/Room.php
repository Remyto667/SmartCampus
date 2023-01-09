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

    #[ORM\Column]
    private ?int $room_size = null;

    #[ORM\Column]
    private ?int $windows_number = null;

    #[ORM\Column(length: 3)]
    private ?string $orientation = null;

    #[ORM\Column]
    private ?int $floor = null;

    private Alert $tempAlert;
    private Alert $humAlert;
    private Alert $co2Alert;

    #[ORM\ManyToOne(inversedBy: 'room')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    /**
     * @param Alert $tempAlert
     * @param Alert $humAlert
     * @param Alert $co2Alert
     */
    public function __construct()
    {
        $this->tempAlert = new Alert(false, '');
        $this->humAlert = new Alert(false, '');
        $this->co2Alert = new Alert(false, '');
    }

    /**
     * @return mixed
     */
    public function getTempAlert() : Alert
    {
        return $this->tempAlert;
    }

    /**
     * @param mixed $tempAlert
     */
    public function setTempAlert(Alert $tempAlert): void
    {
        $this->tempAlert = $tempAlert;
    }

    /**
     * @return mixed
     */
    public function getHumAlert() : Alert
    {
        return $this->humAlert;
    }

    /**
     * @param mixed $humAlert
     */
    public function setHumAlert(Alert $humAlert): void
    {
        $this->humAlert = $humAlert;
    }

    /**
     * @return mixed
     */
    public function getCo2Alert() : Alert
    {
        return $this->co2Alert;
    }

    /**
     * @param mixed $co2Alert
     */
    public function setCo2Alert(Alert $co2Alert): void
    {
        $this->co2Alert = $co2Alert;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setAlert(string $type, Boolean $isAlert): self
    {
        $this->alert[$type] = $isAlert;

        return $this;
    }

    public function getAlert(string $type): self
    {
        return $this->alert[$type];
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
        if ($this->type==0)
            $type="Bureau";
        elseif ($this->type==1)
            $type="Salle de classe";
        elseif ($this->type==2)
            $type="Serveur";
        elseif ($this->type==3)
            $type="Secrétariat";
        elseif ($this->type==4)
            $type="Autres";
        return $type;
    }

    public function setType(Type $type): self
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
        if ($this->orientation=="N")
            $orientation="Nord";
        elseif ($this->orientation=="S")
            $orientation="Sud";
        elseif ($this->orientation=="E")
            $orientation="Est";
        elseif ($this->orientation=="O")
            $orientation="Ouest";
        else
            $orientation="orientation non valide";
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
