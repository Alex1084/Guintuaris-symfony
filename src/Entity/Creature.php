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

    #[ORM\Column]
    private ?bool $tameable = null;

    #[ORM\Column]
    private ?int $physicalAbsorption = null;

    #[ORM\Column]
    private ?int $magicalAbsorption = null;

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

    public function isTameable(): ?bool { return $this->tameable; }
    public function setTameable(bool $tameable): static
    {
        $this->tameable = $tameable;
        return $this;
    }

    public function getPhysicalAbsorption(): ?int { return $this->physicalAbsorption; }
    public function setPhysicalAbsorption(int $physicalAbsorption): static
    {
        $this->physicalAbsorption = $physicalAbsorption;
        return $this;
    }

    public function getMagicalAbsorption(): ?int { return $this->magicalAbsorption; }
    public function setMagicalAbsorption(int $magicalAbsorption): static
    {
        $this->magicalAbsorption = $magicalAbsorption;
        return $this;
    }

    public function getInfos()
    {
        $infos = [
            "pv" => $this->getPvMax(),
            "pc" => $this->getPcMax(),
            "pm" => $this->getPmMax(),
            
            "level" => $this->getLevel(),
            // 'talent' => $this->getTalents(),
            "physicalAbsorption" => $this->getPhysicalAbsorption(),
            "magicalAbsorption" => $this->getMagicalAbsorption(),

            "constitution" => $this->getConstitution(),
            "strength" => $this->getStrength(),
            "dexterity" => $this->getDexterity(),
            "intelligence" => $this->getIntelligence(),
            "charisma" => $this->getCharisma(),
            "faith" => $this->getFaith(),
        ];
        return $infos;
    }
}
