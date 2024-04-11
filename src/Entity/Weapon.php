<?php

namespace App\Entity;

use App\Config\Dice;
use App\Repository\WeaponRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WeaponRepository::class)]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 50)]
    #[Assert\Length( 
        min:2,
        max:50,
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    private ?string $name;

    #[ORM\Column]
    private ?int $damage;

    #[ORM\Column(length: 10, enumType: Dice::class)]
    /* #[Assert\Regex(
        pattern: '/^[1-9]?[0-9]D(100|[0-9]?[0-9])$/',
        match: true,
        message: "Vous devez indiquer un nombre de dés suivis d'un \"D\" en majuscule et le dé à lancée. (10D8, 2D12, 1D6 ...)"
    )] */
    private ?Dice $dice;

    public function getId(): ?int { return $this->id; }
    
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDamage(): ?int { return $this->damage; }
    public function setDamage(int $damage): static
    {
        $this->damage = $damage;
        return $this;
    }

    public function getDice(): ?Dice { return $this->dice; }
    public function setDice(Dice $dice): static
    {
        $this->dice = $dice;
        return $this;
    }
}
