<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $distance;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $damage;

    /**
     * @ORM\ManyToOne(targetEntity=Classes::class)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $radius;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $duration;

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

    public function getDistance(): ?int { return $this->distance; }
    public function setDistance(int $distance): self
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

    public function getRadius(): ?string { return $this->radius;}
    public function setRadius(?string $radius): self
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
}
