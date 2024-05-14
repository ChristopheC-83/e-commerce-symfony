<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualpassword', PasswordType::class, [
                'label' => 'Votre mot de passe actuel :',
                'attr' => [
                    'placeholder' => 'Votre mot de passe actuel'
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
                    'label' => 'Votre nouveau mot de passe :',
                    'attr' => [
                        'placeholder' => 'Nouvea mot de passe'
                    ],

                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe :',
                    'attr' => [
                        'placeholder' => 'Confirmation du nouveau  mot de passe'
                    ]
                ],
                'mapped' => false,  // ne pas lier à l'entité User qui n'a qu'un seul password !

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider votre Nouveau Mot de Passe',
                'attr' => [
                    'class' => 'btn-success w-100 my-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
