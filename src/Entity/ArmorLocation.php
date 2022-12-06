<?php

namespace App\Entity;

use App\Repository\ArmorLocationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ArmorLocationRepository::class)]
class ArmorLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(
        min:3,
        max:50,
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement mettre un nom, celui-ci doit faire entre 3 et 50 caractères.")]
    private $name;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $varName;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getVarName(): ?string
    {
        return $this->varName;
    }

    public function setVarName(?string $varName): self
    {
        $this->varName = $varName;

        return $this;
    }
}
