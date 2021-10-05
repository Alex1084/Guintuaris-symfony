<?php

namespace App\Form;

use App\Entity\Personnage;
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
            ->add('force')
            ->add('dexterite')
            ->add('intelligence')
            ->add('charisme')
            ->add('foi')
            ->add('lore')
            ->add('inventaire')
            ->add('po')
            /*->add('joueur')
            ->add('classe')
            ->add('race') */
            /* ->add('equipe') */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}
