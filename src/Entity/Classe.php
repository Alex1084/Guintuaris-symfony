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
     * @ORM\Column(type="string", length=30)
     */
    private $dePv;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $dePm;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $dePc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


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
