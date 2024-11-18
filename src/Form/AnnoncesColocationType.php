<?php

namespace App\Form;

use App\Entity\AnnoncesColocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesColocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maison_id')
            ->add('titre')
            ->add('description')
            ->add('nombre_chambres')
            ->add('prix')
            ->add('date_pub', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnnoncesColocation::class,
        ]);
    }
}
