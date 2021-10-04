<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonnageRepository::class)
 */
class Personnage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $pv;

    /**
     * @ORM\Column(type="integer")
     */
    private $pvMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $pc;

    /**
     * @ORM\Column(type="integer")
     */
    private $pcMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $pm;

    /**
     * @ORM\Column(type="integer")
     */
    private $pmMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\Column(type="integer")
     */
    private $constitution;

    /**
     * @ORM\Column(type="integer")
     */
    private $force;

    /**
     * @ORM\Column(type="integer")
     */
    private $dexterite;

    /**
     * @ORM\Column(type="integer")
     */
    private $intelligence;

    /**
     * @ORM\Column(type="integer")
     */
    private $charisme;

    /**
     * @ORM\Column(type="integer")
     */
    private $foi;

    /**
     * @ORM\Column(type="text")
     */
    private $lore;

    /**
     * @ORM\Column(type="text")
     */
    private $inventaire;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="personnages")
     */
    private $joueur;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="personnages")
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class, inversedBy="personnages")
     */
    private $race;

    /**
     * @ORM\Column(type="integer")
     */
    private $po;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class, inversedBy="personnages")
     */
    private $equipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(int $pv): self
    {
        $this->pv = $pv;

        return $this;
    }

    public function getPvMax(): ?int
    {
        return $this->pvMax;
    }

    public function setPvMax(int $pvMax): self
    {
        $this->pvMax = $pvMax;

        return $this;
    }

    public function getPc(): ?int
    {
        return $this->pc;
    }

    public function setPc(int $pc): self
    {
        $this->pc = $pc;

        return $this;
    }

    public function getPcMax(): ?int
    {
        return $this->pcMax;
    }

    public function setPcMax(int $pcMax): self
    {
        $this->pcMax = $pcMax;

        return $this;
    }

    public function getPm(): ?int
    {
        return $this->pm;
    }

    public function setPm(int $pm): self
    {
        $this->pm = $pm;

        return $this;
    }

    public function getPmMax(): ?int
    {
        return $this->pmMax;
    }

    public function setPmMax(int $pmMax): self
    {
        $this->pmMax = $pmMax;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(int $constitution): self
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getforce(): ?int
    {
        return $this->force;
    }

    public function setforce(int $force): self
    {
        $this->force = $force;

        return $this;
    }

    public function getDexterite(): ?int
    {
        return $this->dexterite;
    }

    public function setDexterite(int $dexterite): self
    {
        $this->dexterite = $dexterite;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getCharisme(): ?int
    {
        return $this->charisme;
    }

    public function setCharisme(int $charisme): self
    {
        $this->charisme = $charisme;

        return $this;
    }

    public function getFoi(): ?int
    {
        return $this->foi;
    }

    public function setFoi(int $foi): self
    {
        $this->foi = $foi;

        return $this;
    }

    public function getLore(): ?string
    {
        return $this->lore;
    }

    public function setLore(string $lore): self
    {
        $this->lore = $lore;

        return $this;
    }

    public function getInventaire(): ?string
    {
        return $this->inventaire;
    }

    public function setInventaire(string $inventaire): self
    {
        $this->inventaire = $inventaire;

        return $this;
    }

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

    public function getPo(): ?int
    {
        return $this->po;
    }

    public function setPo(int $po): self
    {
        $this->po = $po;

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
}
