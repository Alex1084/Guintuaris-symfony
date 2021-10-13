<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Personnage::class, mappedBy="classe")
     */
    private $personnages;

    /**
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="classe")
     */
    private $competences;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $dePv;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $dePm;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $dePc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->personnages = new ArrayCollection();
        $this->competences = new ArrayCollection();
    }

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

    /**
     * @return Collection|Personnage[]
     */
    public function getPersonnages(): Collection
    {
        return $this->personnages;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->personnages->contains($personnage)) {
            $this->personnages[] = $personnage;
            $personnage->setClasse($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnages->removeElement($personnage)) {
            // set the owning side to null (unless already changed)
            if ($personnage->getClasse() === $this) {
                $personnage->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->setClasse($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getClasse() === $this) {
                $competence->setClasse(null);
            }
        }

        return $this;
    }

    public function getDePv(): ?string
    {
        return $this->dePv;
    }

    public function setDePv(string $dePv): self
    {
        $this->dePv = $dePv;

        return $this;
    }

    public function getDePm(): ?string
    {
        return $this->dePm;
    }

    public function setDePm(string $dePm): self
    {
        $this->dePm = $dePm;

        return $this;
    }

    public function getDePc(): ?string
    {
        return $this->dePc;
    }

    public function setDePc(string $dePc): self
    {
        $this->dePc = $dePc;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
