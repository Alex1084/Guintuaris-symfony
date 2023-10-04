<?php

namespace App\Entity;

use App\Repository\BestiaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BestiaryRepository::class)]
class Bestiary extends Sheet
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?BestiaryType $type;

    public function getNote(): ?string { return $this->note; }
    public function setNote(?string $note): static
    {
        $this->note = $note;
        return $this;
    }

    public function getType(): ?BestiaryType { return $this->type; }
    public function setType(?BestiaryType $type): static
    {
        $this->type = $type;
        return $this;
    }
}
