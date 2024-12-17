<?php

namespace App\Form;

use App\Entity\Logement;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;

class LogementType extends AbstractType
{
    private $tokenStorage;
    private $entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $user = $this->tokenStorage->getToken()->getUser();

        $builder
            ->add('Adresse')
            ->add('Code_postal')
            ->add('superficie')
            ->add('Description', FileType::class, [
                'label' => 'image de logement (Des fichiers image seulement)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('date_ajout', null, [
                'widget' => 'single_text',
            ])
            ->add('ProprietaireId', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
                'query_builder' => function () use ($user) {
                    return $this->entityManager->getRepository(Utilisateur::class)->createQueryBuilder('u')
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
            'data_class' => Logement::class,
        ]);
    }
}
