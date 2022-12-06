<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Length(
        min:5,
        max:100,
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:1,
        max:10, 
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    private $level;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Range(
        min:1,
        max:25,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private $cost;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\Range(
        min:1,
        max:10,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private $distance;

    
    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[1-9]?[0-9]D(100|[0-9]?[0-9])$/',
        match: true,
        message: "Vous devez indiquer un nombre de dés suivis d'un d en majuscule et le dé à lancée. (1D8, 2D6 ...)"
    )]
    private $damage;

    #[ORM\ManyToOne(targetEntity: Classes::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $class;

    #[ORM\Column(type: 'float', length: 10, nullable: true)]
    #[Assert\Range(
        min:1,
        max:100,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private $radius;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Length(
        min:5,
        max:10, 
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private $duration;

    #[ORM\ManyToOne(targetEntity: Resource::class)]
    private $resource;

    #[ORM\ManyToOne(targetEntity: DurationType::class)]
    private $durationType;

    #[ORM\ManyToOne(targetEntity: Statistic::class)]
    private $diceThrow;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getLevel(): ?int { return $this->level; }
    public function setLevel(int $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function getCost(): ?string { return $this->cost; }
    public function setCost(string $cost): self
    {
        $this->cost = $cost;
        return $this;
    }

    public function getDistance(): ?float { return $this->distance; }
    public function setDistance(float $distance): self
    {
        $this->distance = $distance;
        return $this;
    }

    public function getDamage(): ?string { return $this->damage; }
    public function setDamage(?string $damage): self
    {
        $this->damage = $damage;
        return $this;
    }

    public function getClass(): ?Classes { return $this->class; }
    public function setClass(?Classes $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function getRadius(): ?float { return $this->radius;}
    public function setRadius(?float $radius): self
    {
        $this->radius = $radius;
        return $this;
    }

    public function getDuration(): ?string { return $this->duration;}
    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getResource(): ?Resource { return $this->resource;}
    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    public function getDurationType(): ?DurationType { return $this->durationType; }
    public function setDurationType(?DurationType $durationType): self
    {
        $this->durationType = $durationType;
        return $this;
    }

    public function getDiceThrow(): ?Statistic
    {
        return $this->diceThrow;
    }

    public function setDiceThrow(?Statistic $diceThrow): self
    {
        $this->diceThrow = $diceThrow;

        return $this;
    }
}
