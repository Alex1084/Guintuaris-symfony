<?php

namespace App\Entity;

use App\Repository\ArmorPieceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ArmorPieceRepository::class)]
#[UniqueEntity(fields:["location", "type"], message: "Erreur, cette combinaison d'armure existe déjà.")]
#[ORM\UniqueConstraint(name : "location_type", columns: ["location_id", "type_id"] )]
class ArmorPiece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArmorLocation $location;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArmorType $type;

    #[ORM\Column]
    private ?int $physicalAbsorption = null;

    #[ORM\Column]
    private ?int $magicalAbsorption = null;

    public function getId(): ?int { return $this->id; }

    public function getLocation(): ?ArmorLocation { return $this->location; }
    public function setLocation(?ArmorLocation $location): static
    {
        $this->location = $location;
        return $this;
    }

    public function getType(): ?ArmorType { return $this->type; }
    public function setType(?ArmorType $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getPhysicalAbsorption(): ?int { return $this->physicalAbsorption; }
    public function setPhysicalAbsorption(int $physicalAbsorption): static
    {
        $this->physicalAbsorption = $physicalAbsorption;
        return $this;
    }

    public function getMagicalAbsorption(): ?int { return $this->magicalAbsorption; }
    public function setMagicalAbsorption(int $magicalAbsorption): static
    {
        $this->magicalAbsorption = $magicalAbsorption;
        return $this;
    }
}
