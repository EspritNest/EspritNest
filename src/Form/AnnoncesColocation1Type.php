<?php

namespace App\Form;

use App\Entity\AnnoncesColocation;
use App\Entity\Logement;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AnnoncesColocation1Type extends AbstractType
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupérer l'utilisateur connecté
        $user = $this->tokenStorage->getToken()?->getUser();

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
                'choice_label' => 'adresse',
                'query_builder' => function (EntityRepository $repository) use ($user) {
                    return $repository->createQueryBuilder('l')
                        ->where('l.ProprietaireId = :user')
                        ->setParameter('user', $user);
                },
                'placeholder' => 'Sélectionnez un logement',
            ])
            ->add('UserId', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
                'query_builder' => function (EntityRepository $repository) use ($user) {
                    return $repository->createQueryBuilder('u')
                        ->where('u.id = :userId')
                        ->setParameter('userId', $user->getId());
                },
                'disabled' => true,
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
