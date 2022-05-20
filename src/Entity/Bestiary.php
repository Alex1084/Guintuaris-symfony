<?php

namespace App\Entity;

use App\Repository\BestiaryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BestiaryRepository::class)]
class Bestiary extends Sheet
{
    #[ORM\Column(type: 'text', nullable: true)]
    private $note;

    #[ORM\ManyToOne(targetEntity: BestiaryType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    public function getNote(): ?string { return $this->note; }
    public function setNote(?string $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function getType(): ?BestiaryType { return $this->type; }
    public function setType(?BestiaryType $type): self
    {
        $this->type = $type;
        return $this;
    }
}
