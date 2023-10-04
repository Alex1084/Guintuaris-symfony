<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min:3,
        max:50, 
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    private ?string $label;

    #[ORM\Column(length: 2)]
    #[Assert\Length(
        min:1,
        max:5, 
        maxMessage: "Le diminutif doit faire {{ limit }} caractères maximum.",
        minMessage: "Le diminutif doit faire {{ limit }} caractères minimum."
    )]
    private ?string $symbol;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description;

    public function getId(): ?int { return $this->id; }

    public function getLabel(): ?string { return $this->label; }
    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getSymbol(): ?string { return $this->symbol; }
    public function setSymbol(string $symbol): static
    {
        $this->symbol = $symbol;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function __toString()
    {
        return $this->getSymbol()." (".$this->getLabel().")";
    }
}
