<?php

namespace App\Entity;

use App\Repository\PieceArmurePersonnageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PieceArmurePersonnageRepository::class)
 */
class PieceArmurePersonnage
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity=Personnage::class)
     * @ORM\JoinColumn(name="personnage_id", referencedColumnName="id")
     */
    private $personnage;

    /**
     * 
     * @ORM\ManyToOne(targetEntity=PieceArmure::class)
     * @ORM\JoinColumn(name="piece_id", referencedColumnName="id")
     */
    private $piece;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $effet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(?Personnage $personnage): self
    {
        $this->personnage = $personnage;

        return $this;
    }

    public function getPiece(): ?PieceArmure
    {
        return $this->piece;
    }

    public function setPiece(?PieceArmure $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getEffet(): ?string
    {
        return $this->effet;
    }

    public function setEffet($effet): self
    {
        $this->effet = $effet;

        return $this;
    }
}
