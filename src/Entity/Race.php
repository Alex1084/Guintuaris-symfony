<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:3,
        max:30,
        maxMessage: "le nom doit faire 50 caractère maximum",
        minMessage: "le nom doit faire 3 caractère minimum"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'text')]
    private $ability;

    #[ORM\Column(type: 'text')]
    private $bonus;

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

    public function getAbility(): ?string { return $this->ability; }
    public function setAbility(?string $ability): self
    {
        $this->ability = $ability;
        return $this;
    }

    public function getBonus(): ?string { return $this->bonus; }
    public function setBonus(?string $bonus): self
    {
        $this->bonus = $bonus;
        return $this;
    }
}
