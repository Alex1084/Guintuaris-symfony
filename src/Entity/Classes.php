<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClassesRepository::class)]
#[UniqueEntity(fields:["name"], message: "Erreur: ce nom de classe existe déjà.")]
#[UniqueEntity(fields:["slug"], message: "Erreur: le nom normaliser existe déjà.")]
class Classes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 30)]
    #[Assert\Length(
        min:3,
        max:30, 
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement mettre un nom, celui-ci doit faire entre 3 et 50 caractères.")]
    private ?string $name;

    #[ORM\Column(length: 30)]
    #[Assert\Regex(
        pattern: "/^[1-9]?[0-9]D(100|[0-9]?[0-9])/",
        match : true,
        message: "Vous devez indiquer un nombre de dés suivis d'un \"D\" en majuscule et le dé à lancée. (10D8, 2D12, 1D6 ...) suivi d'une statistique (+ Force, + intelligence ...)"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement entrer une valeur dans ce champs")]
    private ?string $dicePv;

    #[ORM\Column(length: 30)]
    #[Assert\Regex(
        pattern: "/^[1-9]?[0-9]D(100|[0-9]?[0-9])/",
        match : true,
        message: "Vous devez indiquer un nombre de dés suivis d'un \"D\" en majuscule et le dé à lancée. (10D8, 2D12, 1D6 ...) suivi d'une statistique (+ Force, + intelligence ...)"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement entrer une valeur dans ce champs")]
    private ?string $dicePm;

    #[ORM\Column(length: 30)]
    #[Assert\Regex(
        pattern: "/^[1-9]?[0-9]D(100|[0-9]?[0-9])/",
        match : true,
        message: "Vous devez indiquer un nombre de dés suivis d'un \"D\" en majuscule et le dé à lancée. (10D8, 2D12, 1D6 ...) suivi d'une statistique (+ Force, + intelligence ...)"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement entrer une valeur dans ce champs")]
    private ?string $dicePc;

    #[ORM\Column(type: Types::TEXT, nullable:true)]
    private ?string $description;

    #[ORM\Column(length: 255)]
    private ?string $slug;


    public function getId(): ?int { return $this->id; }
    
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDicePv(): ?string { return $this->dicePv; }
    public function setDicePv(string $dicePv): static
    {
        $this->dicePv = $dicePv;
        return $this;
    }

    public function getDicePm(): ?string { return $this->dicePm; }
    public function setDicePm(string $dicePm): static
    {
        $this->dicePm = $dicePm;
        return $this;
    }

    public function getDicePc(): ?string { return $this->dicePc; }
    public function setDicePc(string $dicePc): static
    {
        $this->dicePc = $dicePc;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }
}
