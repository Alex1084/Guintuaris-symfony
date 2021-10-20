<?php

namespace App\Entity;

use App\Repository\BestiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BestiaireRepository::class)
 */
class Bestiaire extends Fiche
{
    /**
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="bestiaire")
     */
    private $competance;

    public function __construct()
    {
        $this->competance = new ArrayCollection();
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetance(): Collection
    {
        return $this->competance;
    }

    public function addCompetance(Competence $competance): self
    {
        if (!$this->competance->contains($competance)) {
            $this->competance[] = $competance;
            $competance->setBestiaire($this);
        }

        return $this;
    }

    public function removeCompetance(Competence $competance): self
    {
        if ($this->competance->removeElement($competance)) {
            // set the owning side to null (unless already changed)
            if ($competance->getBestiaire() === $this) {
                $competance->setBestiaire(null);
            }
        }

        return $this;
    }
}
