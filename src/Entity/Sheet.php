<?php

namespace App\Entity;

use App\Repository\SheetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SheetRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name:'discr', type:'string')]
#[ORM\DiscriminatorMap(["sheet" => "Sheet", "character" => "Character","creature" => "Creature", "pet" => "Pet" ])]
abstract class Sheet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min:3,
        max:50,
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement mettre un nom, celui-ci doit faire entre 3 et 50 caractères.")]
    private ?string $name;

    #[ORM\Column]
    #[Assert\Range(
        min:1,
        max:10, 
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $level;

    #[ORM\Column]
    #[Assert\Range(
        min:-500,
        max:500,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    private ?int $pv;

    #[ORM\Column]
    #[Assert\Range(
        min:1,
        max:500,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $pvMax;

    #[ORM\Column]
    #[Assert\Range(
        min:-500,
        max:500,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    private ?int $pc;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:500,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $pcMax;

    #[ORM\Column]
    #[Assert\Range(
        min:-500,
        max:500,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    private ?int $pm;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:500,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $pmMax;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $constitution;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $strength;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $dexterity;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $intelligence;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $charisma;

    #[ORM\Column]
    #[Assert\Range(
        min:0,
        max:85,
        invalidMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}.", 
        notInRangeMessage: "La valeur est incorrecte, veuillez entrer un nombre compris en {{ min }} et {{ max }}." 
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement donner une valeur comprise entre {{ min }} et {{ max }}.")]
    private ?int $faith;

    #[ORM\Column(type: 'datetime_immutable',nullable: false)]
    private $created_at;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $talents = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?int $experience = null;

    #[ORM\Column(nullable: true)]
    private ?array $skills = null;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getPv(): ?int { return $this->pv; }
    public function setPv(int $pv): static
    {
        $this->pv = $pv;
        return $this;
    }

    public function getPvMax(): ?int { return $this->pvMax; }
    public function setPvMax(int $pvMax): static
    {
        $this->pvMax = $pvMax;
        return $this;
    }

    public function getPc(): ?int { return $this->pc; }
    public function setPc(int $pc): static
    {
        $this->pc = $pc;
        return $this;
    }

    public function getPcMax(): ?int { return $this->pcMax; }
    public function setPcMax(int $pcMax): static
    {
        $this->pcMax = $pcMax;
        return $this;
    }

    public function getPm(): ?int { return $this->pm; }
    public function setPm(int $pm): static
    {
        $this->pm = $pm;
        return $this;
    }

    public function getPmMax(): ?int { return $this->pmMax; }
    public function setPmMax(int $pmMax): static
    {
        $this->pmMax = $pmMax;
        return $this;
    }

    public function getLevel(): ?int { return $this->level; }
    public function setLevel(int $level): static
    {
        $this->level = $level;
        return $this;
    }

    public function getConstitution(): ?int { return $this->constitution; }
    public function setConstitution(int $constitution): static
    {
        $this->constitution = $constitution;
        return $this;
    }

    public function getStrength(): ?int { return $this->strength; } 
    public function setStrength(int $strength): static 
    { 
        $this->strength = $strength;
        return $this;
    }

    public function getDexterity(): ?int { return $this->dexterity; }
    public function setDexterity(int $dexterity): static
    {
        $this->dexterity = $dexterity;
        return $this;
    }

    public function getIntelligence(): ?int { return $this->intelligence; }
    public function setIntelligence(int $intelligence): static
    {
        $this->intelligence = $intelligence;
        return $this;
    }

    public function getCharisma(): ?int { return $this->charisma; }
    public function setCharisma(int $charisma): static
    {
        $this->charisma = $charisma;
        return $this;
    }

    public function getFaith(): ?int { return $this->faith; }
    public function setFaith(int $faith): static
    {
        $this->faith = $faith;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->created_at; }
    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getTalents(): ?array { return $this->talents; }
    public function setTalents(?array $talents): static
    {
        $this->talents = $talents;
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

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getSkills(): ?array
    {
        return $this->skills;
    }

    public function setSkills(?array $skills): static
    {
        $this->skills = $skills;

        return $this;
    }
}
