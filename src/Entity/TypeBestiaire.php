<?php

namespace App\Entity;

use App\Repository\TypeBestiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeBestiaireRepository::class)
 */
class TypeBestiaire
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
     * @ORM\OneToMany(targetEntity=Bestiaire::class, mappedBy="type")
     */
    private $bestiaires;

    public function __construct()
    {
        $this->bestiaires = new ArrayCollection();
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
     * @return Collection|Bestiaire[]
     */
    public function getBestiaires(): Collection
    {
        return $this->bestiaires;
    }

    public function addBestiaire(Bestiaire $bestiaire): self
    {
        if (!$this->bestiaires->contains($bestiaire)) {
            $this->bestiaires[] = $bestiaire;
            $bestiaire->setType($this);
        }

        return $this;
    }

    public function removeBestiaire(Bestiaire $bestiaire): self
    {
        if ($this->bestiaires->removeElement($bestiaire)) {
            // set the owning side to null (unless already changed)
            if ($bestiaire->getType() === $this) {
                $bestiaire->setType(null);
            }
        }

        return $this;
    }
}
