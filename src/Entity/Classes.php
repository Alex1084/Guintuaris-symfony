<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClassesRepository::class)]
#[UniqueEntity(fields:["name"], message: "erreur: cette combinaison d'amure existe déjà")]
#[UniqueEntity(fields:["slug"], message: "erreur: cette combinaison d'amure existe déjà")]
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
        maxMessage: "le nom doit faire 50 caractère maximum",
        minMessage: "le nom doit faire 3 caractère minimum"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $name;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:5,
        max:30,
        maxMessage: "le nom doit faire 50 caractère maximum",
        minMessage: "le nom doit faire 3 caractère minimum"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $dicePv;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:5,
        max:30,
        maxMessage: "le nom doit faire 50 caractère maximum",
        minMessage: "le nom doit faire 3 caractère minimum"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 3 et 50 caractere")]
    private $dicePm;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(
        min:5,
        max:30,
        maxMessage: "le nom doit faire 50 caractère maximum",
        minMessage: "le nom doit faire 3 caractère minimum"
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
