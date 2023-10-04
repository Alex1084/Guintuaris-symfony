<?php

namespace App\Entity;

use App\Repository\StatisticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StatisticRepository::class)]
class Statistic
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
    private ?string $name;

    #[ORM\Column(length: 10)]
    #[Assert\Length(
        min:1,
        max:5, 
        maxMessage: "Le diminutif doit faire {{ limit }} caractères maximum.",
        minMessage: "Le diminutif doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement mettre un diminutif, celui-ci doit faire entre 1 et 5 caractères.")]
    private ?string $symbol;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static
    {
        $this->name = $name;
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
}
