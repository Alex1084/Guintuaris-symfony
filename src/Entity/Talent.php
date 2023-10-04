<?php

namespace App\Entity;

use App\Repository\TalentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TalentRepository::class)]
#[UniqueEntity(fields:["name"], message: "Erreur: ce nom de classe existe déjà.")]
#[UniqueEntity(fields:["slug"], message: "Erreur: le nom normaliser existe déjà.")]
class Talent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 50)]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statistic $statistic;

    #[ORM\Column(length: 255,nullable : false)]
    private ?string $slug;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string {return $this->name; }
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getStatistic(): ?Statistic { return $this->statistic;}
    public function setStatistic(?Statistic $statistic): static
    {
        $this->statistic = $statistic;
        return $this;
    }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }
}
