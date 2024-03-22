<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[ORM\Table(name: '`pet`')]
class Pet extends Sheet
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $owner = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[NotBlank(message: "veuillez choisir une creature")]
    #[NotNull(message: "veuillez choisir une creature")]
    private ?Creature $species = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lore = null;

    #[ORM\Column]
    private ?int $physicalAbsorption = null;

    #[ORM\Column]
    private ?int $magicalAbsorption = null;

    public function getOwner(): ?Character
    {
        return $this->owner;
    }

    public function setOwner(?Character $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getSpecies(): ?Creature
    {
        return $this->species;
    }

    public function setSpecies(?Creature $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLore(): ?string
    {
        return $this->lore;
    }

    public function setLore(?string $lore): static
    {
        $this->lore = $lore;

        return $this;
    }

    public function getPhysicalAbsorption(): ?int
    {
        return $this->physicalAbsorption;
    }

    public function setPhysicalAbsorption(int $physicalAbsorption): static
    {
        $this->physicalAbsorption = $physicalAbsorption;

        return $this;
    }

    public function getMagicalAbsorption(): ?int
    {
        return $this->magicalAbsorption;
    }

    public function setMagicalAbsorption(int $magicalAbsorption): static
    {
        $this->magicalAbsorption = $magicalAbsorption;

        return $this;
    }
}
