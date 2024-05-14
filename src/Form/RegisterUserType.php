<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email :',
                'attr' => [
                    'placeholder' => 'Indiquer votre adresse email'
                ]

            ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'max' => 30,
                    ])
                ],
                'first_options' => [
                    'label' => 'Votre mot de passe :',
                    'attr' => [
                        'placeholder' => 'Votre mot de passe'
                    ],

                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe :',
                    'attr' => [
                        'placeholder' => 'Confirmation du mot de passe'
                    ]
                ],
                'mapped' => false,  // ne pas lier à l'entité User qui n'a qu'un seul password !

            ])


            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom :',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 30,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Ici, votre prénom...'
                ]

            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom :',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 30,
                    ])
                ],
                'attr' => [
                    'placeholder' => 'et là, votre nom !'
                ]

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn-primary w-100 my-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // vérifie si l'email n'est pas déjà utilisé par rapport
            //  à la globalité de la DB, pas de l'user en cours
            'constraints' => [
                new UniqueEntity([
                    'fields' => 'email',
                    'message' => 'Cet email est déjà utilisé'
                ]),
                new UniqueEntity([
                    'fields' => 'firstname',
                    'message' => 'Ce pseudo est déjà utilisé'
                ])
            ],
            'data_class' => User::class,
        ]);
    }
}
