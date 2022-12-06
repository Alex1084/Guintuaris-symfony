<?php

namespace App\Entity;

use App\Repository\ArmorPieceCharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArmorPieceCharacterRepository::class)]
class ArmorPieceCharacter
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\Id]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE" )]
    private $charact;

    #[ORM\ManyToOne(targetEntity: ArmorPiece::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $piece;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Assert\Length(
        min:5,
        max:50,  
        maxMessage: "L'effet doit faire {{ limit }} caractères maximum.",
        minMessage: "L'effet doit faire {{ limit }} caractères minimum."
    )]
    private $effect;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
    
    public function getCharact(): ?Character
    {
        return $this->charact;
    }

    public function setCharact(?Character $charact): self
    {
        $this->charact = $charact;

        return $this;
    }

    public function getPiece(): ?ArmorPiece
    {
        return $this->piece;
    }

    public function setPiece(?ArmorPiece $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getEffect(): ?string
    {
        return $this->effect;
    }

    public function setEffect(?string $effect): self
    {
        $this->effect = $effect;

        return $this;
    }
}
