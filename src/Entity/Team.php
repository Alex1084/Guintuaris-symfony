<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min:5,
        max:50, 
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    private ?string $name;

    #[ORM\Column(length: 255)]
    private ?string $slug;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $master;


    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getMaster(): ?User { return $this->master; }
    public function setMaster(?User $master): static
    {
        $this->master = $master;
        return $this;
    }
}
