<?php

namespace App\Entity;

use App\Config\Dice;
use App\Repository\WeaponCharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WeaponCharacterRepository::class)]
class WeaponCharacter
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Character $charact;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Weapon $weapon;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(
        min:5,
        max:50,
        maxMessage: "L'effet doit faire {{ limit }} caractères maximum.",
        minMessage: "L'effet doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\IsNull()]
    private ?string $effect;

    #[ORM\Column(nullable: true)]
    private ?int $damage = null;

    #[ORM\Column(length: 10, nullable: true, enumType: Dice::class)]
    private ?Dice $dice = null;

    public function getId(): ?int { return $this->id; }
    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getCharact(): ?Character { return $this->charact; }
    public function setCharact(?Character $charact): static
    {
        $this->charact = $charact;
        return $this;
    }

    public function getWeapon(): ?Weapon { return $this->weapon; }
    public function setWeapon(?Weapon $weapon): static
    {
        $this->weapon = $weapon;
        return $this;
    }

    public function getEffect(): ?string { return $this->effect; }
    public function setEffect(?string $effect): static
    {
        $this->effect = $effect;
        return $this;
    }

    public function getDamage(): ?int { return $this->damage; }
    public function setDamage(?int $damage): static
    {
        $this->damage = $damage;
        return $this;
    }

    public function getDice(): ?Dice { return $this->dice; }
    public function setDice(?Dice $dice): static
    {
        $this->dice = $dice;
        return $this;
    }
}
