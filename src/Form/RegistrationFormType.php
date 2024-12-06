<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Full Name',
                'attr' => [
                    'placeholder' => 'Enter your full name',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email Address',
                'attr' => [
                    'placeholder' => 'Enter your email',
                ],
            ])
            ->add('Tel', TelType::class, [
                'label' => 'Phone Number',
                'attr' => [
                    'placeholder' => 'Enter your phone number',
                ],
            ])
            ->add('img', UrlType::class, [
                'label' => 'Profile Image URL',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter a URL for your profile image',
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Enter a secure password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Agree to terms and conditions',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You must agree to the terms and conditions.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
