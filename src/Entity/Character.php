<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character extends Sheet
{

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?User $user;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classes $class;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Race $race;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL" )]
    private ?Team $team;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lore;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $inventory;

    #[ORM\Column(nullable: true)]
    private ?int $gold;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image;

    #[ORM\Column(length: 255)]
    private ?string $slug;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_view;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $talents = [];

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getClass(): ?Classes { return $this->class; }
    public function setClass(?Classes $class): static
    {
        $this->class = $class;
        return $this;
    }

    public function getRace(): ?Race { return $this->race; }
    public function setRace(?Race $race): static
    {
        $this->race = $race;
        return $this;
    }

    public function getTeam(): ?Team { return $this->team; }
    public function setTeam(?Team $team): static
    {
        $this->team = $team;
        return $this;
    }

    public function getLore(): ?string { return $this->lore; }
    public function setLore(?string $lore): static
    {
        $this->lore = $lore;
        return $this;
    }

    public function getInventory(): ?string { return $this->inventory; }
    public function setInventory(?string $inventory): static
    {
        $this->inventory = $inventory;
        return $this;
    }

    public function getGold(): ?int { return $this->gold; }
    public function setGold(int $gold): static
    {
        $this->gold = $gold;
        return $this;
    }

    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getLastView(): ?\DateTimeInterface { return $this->last_view; }
    public function setLastView(?\DateTimeInterface $last_view): static
    {
        $this->last_view = $last_view;
        return $this;
    }

    public function getTalents(): ?array { return $this->talents; }
    public function setTalents(?array $talents): static
    {
        $this->talents = $talents;
        return $this;
    }

    public function __toString()
    {
        return $this->getName() . " ( utilisateur : ". $this->getUser()." )";   
    }
}
