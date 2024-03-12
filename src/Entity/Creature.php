<?php

namespace App\Entity;

use App\Repository\CreatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreatureRepository::class)]
class Creature extends Sheet
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CreatureType $type = null;

    public function getNote(): ?string { return $this->note; }
    public function setNote(?string $note): static
    {
        $this->note = $note;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getType(): ?CreatureType { return $this->type; }
    public function setType(?CreatureType $type): static
    {
        $this->type = $type;
        return $this;
    }
}
