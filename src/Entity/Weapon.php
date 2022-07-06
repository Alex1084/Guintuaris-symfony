<?php

namespace App\Entity;

use App\Repository\WeaponRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WeaponRepository::class)]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length( min:2,
    max:50,
    maxMessage: "le nom doit faire 50 caractère maximum",
    minMessage: "le nom doit faire 2 caractère minimum")]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $damage;

    #[ORM\Column(type: 'string', length: 10)]
    private $dice;

    public function getId(): ?int { return $this->id; }
    
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDamage(): ?int { return $this->damage; }
    public function setDamage(int $damage): self
    {
        $this->damage = $damage;
        return $this;
    }

    public function getDice(): ?string { return $this->dice; }
    public function setDice(string $dice): self
    {
        $this->dice = $dice;
        return $this;
    }
}
