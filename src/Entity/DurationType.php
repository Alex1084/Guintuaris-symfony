<?php

namespace App\Entity;

use App\Repository\DurationTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DurationTypeRepository::class)]
class DurationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min:3,
        max:50, 
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement mettre un nom, celui-ci doit faire entre 3 et 50 caractères.")]
    private ?string $label;

    #[ORM\Column(length: 5)]
    #[Assert\Length(
        min:1,
        max:5, 
        maxMessage: "Le diminutif doit faire {{ limit }} caractères maximum.",
        minMessage: "Le diminutif doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement mettre un diminutif, celui-ci doit faire entre 1 et 5 caractères.")]
    private ?string $symbol;

    public function getId(): ?int { return $this->id;}

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
}
