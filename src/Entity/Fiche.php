<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FicheRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=FicheRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * {
 *      "fiche" = "Fiche", 
 *      "character" = "Character",
 *      "personnage" = "Personnage",
 *      "bestiaire" = "Bestiaire"
 * })
 */
abstract class Fiche
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min=3,
     *      max=50,
     * )
     * @Groups({"read"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=1,
     *      max=10,
     * )
     * @Groups({"read"})
     */
    private $level;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=10,
     *      max=500,
     * )
     * @Groups({"read"})
     */
    private $pv;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=10,
     *      max=500,
     * )
     * @Groups({"read"})
     */
    private $pvMax;

    /**
     * @ORM\Column(type="integer")
     
     * @Assert\Range(
     *      min=0,
     *      max=500,
     * )
     * @Groups({"read"})
     */
    private $pc;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=500,
     * )
     * @Groups({"read"})
     */
    private $pcMax;


    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=500,
     * )
     * @Groups({"read"})
     */
    private $pm;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=500,
     * )
     * @Groups({"read"})
     */
    private $pmMax;


    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=85,
     * )
     * @Groups({"read"})
     */
    private $constitution;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=85,
     * )
     * @Groups({"read"})
     */
    private $strength;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=85,
     * )
     * @Groups({"read"})
     */
    private $dexterity;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=85,
     * )
     * @Groups("read")
     */
    private $intelligence;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=85,
     * )
     * @Groups({"read"})
     */
    private $charisma;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min=0,
     *      max=85,
     * )
     * @Groups({"read"})
     */
    private $faith;

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
}
