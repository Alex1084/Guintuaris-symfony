<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nom",
            'attr' => [
                "max" => 50
            ],
            'constraints' => [
                new Length([
                    "min" => 5,
                    "max" => 50,
                    "maxMessage" =>  "le nom doit faire 50 caractère maximum",
                    "minMessage" =>  "le nom doit faire 5 caractère minimum"
                ]),
                new NotBlank( [
                    "message" => "erreur : ce champ ne peut pas etre vide, celui-ci doit faire entre 5 et 50 caractere"
                ])
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
