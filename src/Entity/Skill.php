<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min:5,
        max:100,
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column]
    #[Assert\Range(
        min:1,
        max:10, 
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    private ?int $level;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min:1,
        max:25,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private ?int $cost;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min:1,
        max:10,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private ?float $distance;

    
    #[ORM\Column(length: 10, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[1-9]?[0-9]D(100|[0-9]?[0-9])$/',
        match: true,
        message: "Vous devez indiquer un nombre de dés suivis d'un \"D\" en majuscule et le dé à lancée. (10D8, 2D12, 1D6 ...)"
    )]
    private ?string $damage;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classes $class;

    #[ORM\Column(length: 10, nullable: true)]
    #[Assert\Range(
        min:1,
        max:100,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private ?float $radius;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        min:5,
        max:10, 
        minMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        maxMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private ?int $duration;

    #[ORM\ManyToOne]
    private ?Resource $resource;

    #[ORM\ManyToOne]
    private ?DurationType $durationType;

    #[ORM\ManyToOne]
    private ?Statistic $diceThrow;

    #[ORM\Column()]
    private ?int $experience = 0;

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

    public function getLevel(): ?int { return $this->level; }
    public function setLevel(int $level): static
    {
        $this->level = $level;
        return $this;
    }

    public function getCost(): ?string { return $this->cost; }
    public function setCost(string $cost): static
    {
        $this->cost = $cost;
        return $this;
    }

    public function getDistance(): ?float { return $this->distance; }
    public function setDistance(float $distance): static
    {
        $this->distance = $distance;
        return $this;
    }

    public function getDamage(): ?string { return $this->damage; }
    public function setDamage(?string $damage): static
    {
        $this->damage = $damage;
        return $this;
    }

    public function getClass(): ?Classes { return $this->class; }
    public function setClass(?Classes $class): static
    {
        $this->class = $class;
        return $this;
    }

    public function getRadius(): ?float { return $this->radius; }
    public function setRadius(?float $radius): static
    {
        $this->radius = $radius;
        return $this;
    }

    public function getDuration(): ?string { return $this->duration; }
    public function setDuration(?string $duration): static
    {
        $this->duration = $duration;
        return $this;
    }

    public function getResource(): ?Resource { return $this->resource; }
    public function setResource(?Resource $resource): static
    {
        $this->resource = $resource;
        return $this;
    }

    public function getDurationType(): ?DurationType { return $this->durationType; }
    public function setDurationType(?DurationType $durationType): static
    {
        $this->durationType = $durationType;
        return $this;
    }

    public function getDiceThrow(): ?Statistic
    {
        return $this->diceThrow;
    }

    public function setDiceThrow(?Statistic $diceThrow): static
    {
        $this->diceThrow = $diceThrow;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }
}
