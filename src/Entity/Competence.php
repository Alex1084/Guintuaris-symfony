<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="competences")
     */
    private $classe;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $cout;

    /**
     * @ORM\Column(type="integer")
     */
    private $portee;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $degat;

    /**
     * @ORM\ManyToOne(targetEntity=Bestiaire::class, inversedBy="competance")
     */
    private $bestiaire;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getCout(): ?string
    {
        return $this->cout;
    }

    public function setCout(string $cout): self
    {
        $this->cout = $cout;

        return $this;
    }

    public function getportee(): ?int
    {
        return $this->portee;
    }

    public function setportee(int $portee): self
    {
        $this->portee = $portee;

        return $this;
    }

    public function getDegat(): ?string
    {
        return $this->degat;
    }

    public function setDegat(?string $degat): self
    {
        $this->degat = $degat;

        return $this;
    }

    public function getBestiaire(): ?Bestiaire
    {
        return $this->bestiaire;
    }

    public function setBestiaire(?Bestiaire $bestiaire): self
    {
        $this->bestiaire = $bestiaire;

        return $this;
    }
}
