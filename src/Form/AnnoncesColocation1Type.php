<?php

namespace App\Form;

use App\Entity\AnnoncesColocation;
use App\Entity\Logement;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesColocation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('nombre_chambres')
            ->add('prix')
            ->add('date_pub', null, [
                'widget' => 'single_text',
            ])
            ->add('Logement', EntityType::class, [
                'class' => Logement::class,
                'choice_label' => 'id',
            ])
            ->add('UserId', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
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
