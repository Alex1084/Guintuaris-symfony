<?php

namespace App\Entity;

use App\Repository\WeaponCharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WeaponCharacterRepository::class)]
class WeaponCharacter
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private $charact;

    #[ORM\ManyToOne(targetEntity: Weapon::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $weapon;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Assert\Length(min:5,max:50, )]
    private $effect;

    public function getId(): ?int { return $this->id; }
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCharact(): ?Character { return $this->charact; }
    public function setCharact(?Character $charact): self
    {
        $this->charact = $charact;
        return $this;
    }

    public function getWeapon(): ?Weapon { return $this->weapon; }
    public function setWeapon(?Weapon $weapon): self
    {
        $this->weapon = $weapon;
        return $this;
    }

    public function getEffect(): ?string { return $this->effect; }
    public function setEffect(?string $effect): self
    {
        $this->effect = $effect;
        return $this;
    }
}
