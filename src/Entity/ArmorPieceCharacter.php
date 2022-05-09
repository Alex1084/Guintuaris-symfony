<?php

namespace App\Entity;

use App\Repository\ArmorPieceCharacterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArmorPieceCharacterRepository::class)
 */
class ArmorPieceCharacter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity=Character::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $charact;

    /**
     * @ORM\ManyToOne(targetEntity=ArmorPiece::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $piece;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
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
