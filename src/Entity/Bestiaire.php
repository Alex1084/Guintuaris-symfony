<?php

namespace App\Entity;

use App\Repository\BestiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BestiaireRepository::class)
 */
class Bestiaire extends Fiche
{
    /**
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="bestiaire")
     */
    private $competance;

    /**
     * @ORM\ManyToOne(targetEntity=TypeBestiaire::class, inversedBy="bestiaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("post:read")
     */
    private $note;

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

    public function getType(): ?TypeBestiaire
    {
        return $this->type;
    }

    public function setType(?TypeBestiaire $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
