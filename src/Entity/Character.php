<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="`character`")
 */
class Character extends Sheet
{

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Classes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $class;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lore;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $inventory;

    /**
     * @ORM\Column(type="integer")
     *   @Assert\Range( 
     *      min=0,
     *      max=999999999,
     * )
     */
    private $gold;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getClass(): ?Classes { return $this->class; }
    public function setClass(?Classes $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function getRace(): ?Race { return $this->race; }
    public function setRace(?Race $race): self
    {
        $this->race = $race;
        return $this;
    }

    public function getTeam(): ?Equipe { return $this->team; }
    public function setTeam(?Equipe $team): self
    {
        $this->team = $team;
        return $this;
    }

    public function getLore(): ?string { return $this->lore; }
    public function setLore(?string $lore): self
    {
        $this->lore = $lore;
        return $this;
    }

    public function getInventory(): ?string { return $this->inventory; }
    public function setInventory(?string $inventory): self
    {
        $this->inventory = $inventory;
        return $this;
    }

    public function getGold(): ?int { return $this->gold; }
    public function setGold(int $gold): self
    {
        $this->gold = $gold;
        return $this;
    }

    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
}
