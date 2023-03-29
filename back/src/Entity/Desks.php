<?php

namespace App\Entity;

use App\Repository\DesksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DesksRepository::class)]
class Desks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 50)]
    private ?string $adress = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 25)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $numberPlaces = null;

    #[ORM\OneToMany(mappedBy: 'desks', targetEntity: Bookings::class)]
    private Collection $bookings;

    #[ORM\ManyToOne(inversedBy: 'desks')]
    private ?Users $owners = null;

    #[ORM\ManyToOne(inversedBy: 'desks')]
    private ?StatusDesks $statusDesks = null;

    #[ORM\OneToMany(mappedBy: 'desks', targetEntity: Availability::class)]
    private Collection $availabilities;

    #[ORM\OneToMany(mappedBy: 'desks', targetEntity: Images::class)]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: Options::class, inversedBy: 'desks')]
    private Collection $options;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNumberPlaces(): ?int
    {
        return $this->numberPlaces;
    }

    public function setNumberPlaces(int $numberPlaces): self
    {
        $this->numberPlaces = $numberPlaces;

        return $this;
    }

    /**
     * @return Collection<int, Bookings>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Bookings $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setDesks($this);
        }

        return $this;
    }

    public function removeBooking(Bookings $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getDesks() === $this) {
                $booking->setDesks(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->owners;
    }

    public function setUsers(?Users $users): self
    {
        $this->owners = $users;

        return $this;
    }

    public function getStatusDesks(): ?StatusDesks
    {
        return $this->statusDesks;
    }

    public function setStatusDesks(?StatusDesks $statusDesks): self
    {
        $this->statusDesks = $statusDesks;

        return $this;
    }

    /**
     * @return Collection<int, Availability>
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities->add($availability);
            $availability->setDesks($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getDesks() === $this) {
                $availability->setDesks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setDesks($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getDesks() === $this) {
                $image->setDesks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Options>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Options $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
        }

        return $this;
    }

    public function removeOption(Options $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }
}
