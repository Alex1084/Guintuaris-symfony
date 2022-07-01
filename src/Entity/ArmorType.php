<?php

namespace App\Entity;

use App\Repository\ArmorTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArmorTypeRepository::class)]
class ArmorType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(
        min:5,
        max:50,
        maxMessage: "le nom doit faire 50 caractère maximum",
        minMessage: "le nom doit faire 5 caractère minimum"
    )]
    #[Assert\NotBlank(message: "vous devez obligatoirement metre un nom, celui-ci doit faire entre 5 et 50 caractere")]
    private $name;

    public function getId(): ?int {return $this->id; }

    public function getName(): ?string {return $this->name; }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
