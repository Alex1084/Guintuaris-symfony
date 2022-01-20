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
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Groups({"note"})
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=TypeBestiaire::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

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
}
