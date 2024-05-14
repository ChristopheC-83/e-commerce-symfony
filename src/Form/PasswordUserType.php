<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Votre mot de passe actuel :',
                'attr' => [
                    'placeholder' => 'Votre mot de passe actuel'
                ],
                'mapped' => false,
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
                        'placeholder' => 'Nouveau mot de passe'
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

            // A quel moment écoute le formulaire ?
            // pour faire quoi ?
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                // die('mon event fonctionne');
    
                //  $event est capable de récupérer un formulaire
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];


                // 1 recup le mdp saisi & compare au mdp en DB
                $actualPassword = $form->get('actualPassword')->getData();
                $isValid = $passwordHasher->isPasswordValid($user, $actualPassword);

                // dd($isValid);
    
                // 2 comparer les 2 mdp, si différent, erreur
                if (!$isValid) {
                    $form->get('actualPassword')->addError(new FormError('Le mot de passe saisi est incorrect'));
                }


            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null
        ]);
    }
}
