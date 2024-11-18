<?php

namespace App\Form;

use App\Entity\Discussions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscussionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('utilisateur1_id')
            ->add('utilisateur2_id')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_At', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Discussions::class,
        ]);
    }
}
