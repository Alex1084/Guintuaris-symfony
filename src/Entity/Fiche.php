<?php

namespace App\Entity;

use App\Repository\FicheRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=FicheRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * {
 *      "fiche" = "Fiche", 
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $pv;

    /**
     * @ORM\Column(type="integer")
     */
    private $pvMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $pc;

    /**
     * @ORM\Column(type="integer")
     */
    private $pcMax;

    
    /**
     * @ORM\Column(type="integer")
     */
    private $pm;

    /**
     * @ORM\Column(type="integer")
     */
    private $pmMax;


    /**
     * @ORM\Column(type="integer")
     */
    private $constitution;

    /**
     * @ORM\Column(type="integer")
     */
    private $laForce;

    /**
     * @ORM\Column(type="integer")
     */
    private $dexterite;

    /**
     * @ORM\Column(type="integer")
     */
    private $intelligence;

    /**
     * @ORM\Column(type="integer")
     */
    private $charisme;

    /**
     * @ORM\Column(type="integer")
     */
    private $foi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(int $pv): self
    {
        $this->pv = $pv;

        return $this;
    }

    public function getPvMax(): ?int
    {
        return $this->pvMax;
    }

    public function setPvMax(int $pvMax): self
    {
        $this->pvMax = $pvMax;

        return $this;
    }

    public function getPc(): ?int
    {
        return $this->pc;
    }

    public function setPc(int $pc): self
    {
        $this->pc = $pc;

        return $this;
    }

    public function getPcMax(): ?int
    {
        return $this->pcMax;
    }

    public function setPcMax(int $pcMax): self
    {
        $this->pcMax = $pcMax;

        return $this;
    }

    public function getPm(): ?int
    {
        return $this->pm;
    }

    public function setPm(int $pm): self
    {
        $this->pm = $pm;

        return $this;
    }

    public function getPmMax(): ?int
    {
        return $this->pmMax;
    }

    public function setPmMax(int $pmMax): self
    {
        $this->pmMax = $pmMax;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(int $constitution): self
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getLaForce(): ?int
    {
        return $this->laForce;
    }

    public function setLaForce(int $laForce): self
    {
        $this->laForce = $laForce;

        return $this;
    }

    public function getDexterite(): ?int
    {
        return $this->dexterite;
    }

    public function setDexterite(int $dexterite): self
    {
        $this->dexterite = $dexterite;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getCharisme(): ?int
    {
        return $this->charisme;
    }

    public function setCharisme(int $charisme): self
    {
        $this->charisme = $charisme;

        return $this;
    }

    public function getFoi(): ?int
    {
        return $this->foi;
    }

    public function setFoi(int $foi): self
    {
        $this->foi = $foi;

        return $this;
    }
}
