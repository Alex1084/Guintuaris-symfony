<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Repository\ArmorLocationRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArmorPieceCharacterType extends AbstractType
{

    public function __construct(ArmorLocationRepository $armorLocationRepository)
    {
        $locations = $armorLocationRepository->findBy([], ["id" => "ASC"]);
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($this->locations as $location) {
            $name = $location->getVarName();
            $str = 'effet_' . $name;

            //ajout d'un Select avec en option les piece d'armure apartenent a la localisation $i
            $builder
            ->add($name, EntityType::class, [
                'class' => ArmorPiece::class,
                "label" => $location->getName(),
                'choice_label' => 'type.name',
                'query_builder' => $armorPieceRepository->optionType($location->getId()),
                'preferred_choices' => $armorPieceRepository->findEmptybyLocation($location->getId()),
                'data' => $armor[$location->getId() - 1]->getPiece(),
                'attr' => ['class' => 'input-form']
            ])
            //ajout d'un champs string pour metre l'effet de la piece d'armure
            ->add($str, TextType::class, [
                'required' => false,
                'data' => $armor[$location->getId() - 1]->getEffect(),
                'label' => 'Effet',
                'attr' => ['class' => 'input-form'],
                'constraints' => [
                    new Length([
                        "min" => 5,
                        "max" => 50,
                        "maxMessage" =>  "le nom doit faire 50 caractère maximum",
                        "minMessage" =>  "le nom doit faire 5 caractère minimum"
                    ]),
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
