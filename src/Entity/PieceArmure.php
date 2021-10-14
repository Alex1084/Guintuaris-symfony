<?php

namespace App\Entity;

use App\Repository\PieceArmureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PieceArmureRepository::class)
 */
class PieceArmure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=LocalisationArmure::class)
     */
    private $localisation;

    /**
     * @ORM\ManyToOne(targetEntity=TypeArmure::class)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $valeur;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getlocalisation(): ?LocalisationArmure
    {
        return $this->localisation;
    }

    public function setlocalisation(?LocalisationArmure $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getType(): ?TypeArmure
    {
        return $this->type;
    }

    public function setType(?TypeArmure $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
}
