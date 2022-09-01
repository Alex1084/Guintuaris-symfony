<?php

namespace App\Entity;

use App\Repository\SheetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SheetRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name:'discr', type:'string')]
#[ORM\DiscriminatorMap(["sheet" => "Sheet", "character" => "Character","bestiary" => "Bestiary" ])]
abstract class Sheet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(
        min:3,
        max:50,
        maxMessage: "le nom doit faire 50 caractère maximum",
        minMessage: "le nom doit faire 3 caractère minimum"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $name;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:1,
        max:10, 
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 1 et 10", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 1 et 10" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 1 et 10")]
    private $level;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:-500,
        max:500,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 1 et 500", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 1 et 500" 
    )]
    private $pv;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:500,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 1 et 500", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 1 et 500" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 1 et 500")]
    private $pvMax;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:-500,
        max:500,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500" 
    )]
    private $pc;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:500,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 500")]
    private $pcMax;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:-500,
        max:500,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500" 
    )]
    private $pm;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:500,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 500" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 500")]
    private $pmMax;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 85")]
    private $constitution;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 85")]
    private $strength;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 85")]
    private $dexterity;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 85")]
    private $intelligence;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 85")]
    private $charisma;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85", 
        notInRangeMessage: "valeur incorect, veuillez entré un nombre compris en 0 et 85" 
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement donnez un valeur comprise entre 0 et 85")]
    private $faith;

    #[ORM\Column(type: 'datetime_immutable',nullable: false)]
    private $created_at;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPv(): ?int { return $this->pv; }
    public function setPv(int $pv): self
    {
        $this->pv = $pv;
        return $this;
    }

    public function getPvMax(): ?int { return $this->pvMax; }
    public function setPvMax(int $pvMax): self
    {
        $this->pvMax = $pvMax;
        return $this;
    }

    public function getPc(): ?int { return $this->pc; }
    public function setPc(int $pc): self
    {
        $this->pc = $pc;
        return $this;
    }

    public function getPcMax(): ?int { return $this->pcMax; }
    public function setPcMax(int $pcMax): self
    {
        $this->pcMax = $pcMax;
        return $this;
    }

    public function getPm(): ?int { return $this->pm; }
    public function setPm(int $pm): self
    {
        $this->pm = $pm;
        return $this;
    }

    public function getPmMax(): ?int { return $this->pmMax; }
    public function setPmMax(int $pmMax): self
    {
        $this->pmMax = $pmMax;
        return $this;
    }

    public function getLevel(): ?int { return $this->level; }
    public function setLevel(int $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function getConstitution(): ?int { return $this->constitution; }
    public function setConstitution(int $constitution): self
    {
        $this->constitution = $constitution;
        return $this;
    }

    public function getStrength(): ?int { return $this->strength; } 
    public function setStrength(int $strength): self 
    { 
        $this->strength = $strength;
        return $this;
    }

    public function getDexterity(): ?int { return $this->dexterity; }
    public function setDexterity(int $dexterity): self
    {
        $this->dexterity = $dexterity;
        return $this;
    }

    public function getIntelligence(): ?int { return $this->intelligence; }
    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;
        return $this;
    }

    public function getCharisma(): ?int { return $this->charisma; }
    public function setCharisma(int $charisma): self
    {
        $this->charisma = $charisma;
        return $this;
    }

    public function getFaith(): ?int { return $this->faith; }
    public function setFaith(int $faith): self
    {
        $this->faith = $faith;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
