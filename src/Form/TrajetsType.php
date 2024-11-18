<?php

namespace App\Form;

use App\Entity\Trajets;
use App\Entity\voitures;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('conducteurId')
            ->add('voitureId')
            ->add('pointDepart')
            ->add('pointDarrivee')
            ->add('dateDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('nombrePlaceDispo')
            ->add('prix')
            ->add('heureDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('voitures', EntityType::class, [
                'class' => voitures::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajets::class,
        ]);
    }
}
