<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
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
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:3,
        max:30, 
        maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\NotBlank(message: "Vous devez obligatoirement mettre un nom, celui-ci doit faire entre 3 et 50 caractères.")]
    private $name;
    // TODO add message for Assert & update noBlank message
    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:5,
        max:30,
        // maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        // minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\Regex(
        pattern: "/^[1-9]?[0-9]D(100|[0-9]?[0-9]) [+] /",
        match : true,
        message: "Vous devez indiquer un nombre de dé suivie d'un d en majuscule et le dé à lancée (1D8, 2D6 ...)"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $dicePv;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:5,
        max:30,
        // maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        // minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\Regex(
        pattern: "/^[1-9]?[0-9]D(100|[0-9]?[0-9]) [+] /",
        match : true,
        message: "Vous devez indiquer un nombre de dé suivie d'un d en majuscule et le dé à lancée (1D8, 2D6 ...)"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $dicePm;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:5,
        max:30,
        // maxMessage: "Le nom doit faire {{ limit }} caractères maximum.",
        // minMessage: "Le nom doit faire {{ limit }} caractères minimum."
    )]
    #[Assert\Regex(
        pattern: "/^[1-9]?[0-9]D(100|[0-9]?[0-9]) [+] /",
        match : true,
        message: "Vous devez indiquer un nombre de dé suivie d'un d en majuscule et le dé à lancée (1D8, 2D6 ...)"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $dicePc;

    #[ORM\Column(type: 'text', nullable:true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;


    public function getId(): ?int { return $this->id; }
    
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDicePv(): ?string { return $this->dicePv; }
    public function setDicePv(string $dicePv): self
    {
        $this->dicePv = $dicePv;
        return $this;
    }

    public function getDicePm(): ?string { return $this->dicePm; }
    public function setDicePm(string $dicePm): self
    {
        $this->dicePm = $dicePm;
        return $this;
    }

    public function getDicePc(): ?string { return $this->dicePc; }
    public function setDicePc(string $dicePc): self
    {
        $this->dicePc = $dicePc;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }
}
