<?php

namespace App\Entity;

use App\Repository\OptionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionsRepository::class)]
class Options
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Desks::class, mappedBy: 'options')]
    private Collection $desks;

    public function __construct()
    {
        $this->desks = new ArrayCollection();
    }

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
            $desk->addOption($this);
        }

        return $this;
    }

    public function removeDesk(Desks $desk): self
    {
        if ($this->desks->removeElement($desk)) {
            $desk->removeOption($this);
        }

        return $this;
    }
}
