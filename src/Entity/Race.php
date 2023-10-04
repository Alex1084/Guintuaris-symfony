<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
#[UniqueEntity(fields:["name"], message: "erreur: cette combinaison d'amure existe déjà")]
#[UniqueEntity(fields:["slug"], message: "erreur: cette combinaison d'amure existe déjà")]
class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 30)]
    #[Assert\Length(
        min:3,
        max:30,
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $bonus;

    #[ORM\Column(length: 255)]
    private ?string $slug;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $SocialAbility;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $physicalAbility;

    #[ORM\Column(nullable: false)]
    #[Assert\Positive(message:"La taille minimum doit être un nombre supérieur à zéro.")]
    private ?int $minHeight;

    #[ORM\Column(nullable: false)]
    #[Assert\Positive(message:"La taille maximum doit être un nombre supérieur à zéro.")]
    private ?int $maxHeight;

    #[ORM\Column(nullable: false)]
    #[Assert\Positive(message:"Le poids moyens doit être un nombre supérieur à zéro.")]
    private ?int $averageWheight;

    #[ORM\Column(nullable: false)]
    #[Assert\Positive(message:"l'age adulte doit être un nombre supérieur à zéro.")]
    private ?int $adulthood;

    #[ORM\Column(nullable: false)]
    #[Assert\Positive(message:"La durèe de vie doit être un nombre supérieur à zéro.")]
    private ?int $lifetime;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getBonus(): ?string { return $this->bonus; }
    public function setBonus(?string $bonus): static
    {
        $this->bonus = $bonus;
        return $this;
    }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSocialAbility(): ?string { return $this->SocialAbility; }
    public function setSocialAbility(?string $SocialAbility): static
    {
        $this->SocialAbility = $SocialAbility;
        return $this;
    }

    public function getPhysicalAbility(): ?string { return $this->physicalAbility; }
    public function setPhysicalAbility(?string $physicalAbility): static
    {
        $this->physicalAbility = $physicalAbility;
        return $this;
    }

    public function getMinHeight(): ?int { return $this->minHeight; }
    public function setMinHeight(?int $minHeight): static
    {
        $this->minHeight = $minHeight;
        return $this;
    }

    public function getMaxHeight(): ?int { return $this->maxHeight; }
    public function setMaxHeight(?int $maxHeight): static
    {
        $this->maxHeight = $maxHeight;
        return $this;
    }

    public function getAverageWheight(): ?int { return $this->averageWheight; }
    public function setAverageWheight(?int $averageWheight): static
    {
        $this->averageWheight = $averageWheight;
        return $this;
    }

    public function getAdulthood(): ?int { return $this->adulthood; }
    public function setAdulthood(?int $adulthood): static
    {
        $this->adulthood = $adulthood;
        return $this;
    }

    public function getLifetime(): ?int { return $this->lifetime; }
    public function setLifetime(?int $lifetime): static
    {
        $this->lifetime = $lifetime;
        return $this;
    }
}
