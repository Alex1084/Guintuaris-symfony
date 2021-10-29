<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonnageRepository::class)
 */
class Personnage extends Fiche
{
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $joueur;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipe;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lore;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $inventaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $po;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function getJoueur(): ?User
    {
        return $this->joueur;
    }

    public function setJoueur(?User $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getLore(): ?string
    {
        return $this->lore;
    }

    public function setLore(?string $lore): self
    {
        $this->lore = $lore;

        return $this;
    }

    public function getInventaire(): ?string
    {
        return $this->inventaire;
    }

    public function setInventaire(?string $inventaire): self
    {
        $this->inventaire = $inventaire;

        return $this;
    }

    public function getPo(): ?int
    {
        return $this->po;
    }

    public function setPo(int $po): self
    {
        $this->po = $po;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
