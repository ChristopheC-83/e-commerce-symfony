<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Votre adresse email :',
                'attr' => [
                    'placeholder' => 'Indiquer votre adresse email'
                ]
                
                ])
            ->add('password', PasswordType::class,[
                'label' => 'Votre mot de passe :',
                'attr' => [
                    'placeholder' => 'Merci de choisir votre mot de passe'
                ]
                
                ])
            ->add('firstname', TextType::class,[
                'label' => 'Votre prénom :',
                'attr' => [
                    'placeholder' => 'Ici, votre prénom...'
                ]
                
                ])
            ->add('lastname', TextType::class,[
                'label' => 'Votre nom :',
                'attr' => [
                    'placeholder' => 'et là, votre nom !'
                ]
                
                ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn-success'
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
