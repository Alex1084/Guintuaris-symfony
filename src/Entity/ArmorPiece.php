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
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: ArmorLocation::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $location;

    #[ORM\ManyToOne(targetEntity: ArmorType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:10, 
        notInRangeMessage: "La valeur incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}."
    )]
    private $value;

    public function getId(): ?int { return $this->id; }

    public function getLocation(): ?ArmorLocation { return $this->location; }
    public function setLocation(?ArmorLocation $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getType(): ?ArmorType { return $this->type; }
    public function setType(?ArmorType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): ?int { return $this->value; }
    public function setValue(int $value): self
    {
        $this->value = $value;
        return $this;
    }
}
