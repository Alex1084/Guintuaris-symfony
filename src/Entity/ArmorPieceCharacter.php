<?php

namespace App\Entity;

use App\Repository\ArmorPieceCharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArmorPieceCharacterRepository::class)]
class ArmorPieceCharacter
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id;

    #[ORM\ManyToOne]
    #[ORM\Id]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE" )]
    private ?Character $charact;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?ArmorPiece $piece;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(
        min:5,
        max:50,  
        maxMessage: "L'effet doit faire {{ limit }} caractères maximum.",
        minMessage: "L'effet doit faire {{ limit }} caractères minimum."
    )]
    private ?string $effect;

    #[ORM\Column(nullable:true)]
    private ?int $physicalAbsorption = null;

    #[ORM\Column(nullable:true)]
    private ?int $magicalAbsorption = null;

    public function getId(): ?int { return $this->id; }
    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }
    
    public function getCharact(): ?Character { return $this->charact; }
    public function setCharact(?Character $charact): static
    {
        $this->charact = $charact;
        return $this;
    }

    public function getPiece(): ?ArmorPiece { return $this->piece; }
    public function setPiece(?ArmorPiece $piece): static
    {
        $this->piece = $piece;
        return $this;
    }

    public function getEffect(): ?string { return $this->effect; }
    public function setEffect(?string $effect): static
    {
        $this->effect = $effect;
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
