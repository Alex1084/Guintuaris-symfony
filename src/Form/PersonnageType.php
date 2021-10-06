<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Personnage;
use App\Entity\Race;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('pv')
            ->add('pvMax')
            ->add('pc')
            ->add('pcMax')
            ->add('pm')
            ->add('pmMax')
            ->add('niveau')
            ->add('constitution')
            ->add('laForce')
            ->add('dexterite')
            ->add('intelligence')
            ->add('charisme')
            ->add('foi')
            ->add('lore')
            ->add('inventaire')
            ->add('po')
            ->add('classe', EntityType::class,[
                'class' => Classe::class,
                'choice_label' => 'nom'
            ])
            ->add('race', EntityType::class,[
                'class' => Race::class,
                'choice_label' => 'nom'
            ])
            ->add('joueur')
            /*
            ->add('equipe') */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}
