<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50)]
    private ?string $gender = null;

    #[ORM\Column(length: 50)]
    private ?string $nationality = null;

    #[ORM\Column(length: 30)]
    private ?string $birthDate = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $access = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?StatusUsers $statusUsers = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Bookings::class)]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Desks::class)]
    private Collection $desks;

    #[ORM\Column]
    private ?bool $isCertified = null;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->desks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAccess(): ?\DateTimeInterface
    {
        return $this->access;
    }

    public function setAccess(\DateTimeInterface $access): self
    {
        $this->access = $access;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getStatus(): ?StatusUsers
    {
        return $this->statusUsers;
    }

    public function setStatus(?StatusUsers $status): self
    {
        $this->statusUsers = $status;

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
            $booking->setUsers($this);
        }

        return $this;
    }

    public function removeBooking(Bookings $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getUsers() === $this) {
                $booking->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Desks>
     */
    public function getDesks(): Collection
    {
        return $this->desks;
    }

    public function addDesk(Desks $desk): self
    {
        if (!$this->desks->contains($desk)) {
            $this->desks->add($desk);
            $desk->setUsers($this);
        }

        return $this;
    }

    public function removeDesk(Desks $desk): self
    {
        if ($this->desks->removeElement($desk)) {
            // set the owning side to null (unless already changed)
            if ($desk->getUsers() === $this) {
                $desk->setUsers(null);
            }
        }

        return $this;
    }

    public function getIsCertified(): ?bool
    {
        return $this->isCertified;
    }

    public function setIsCertified(bool $isCertified): self
    {
        $this->isCertified = $isCertified;

        return $this;
    }
}
