<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Indiquez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Indiquez votre nom'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Indiquez votre adresse'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'placeholder' => 'Indiquez votre code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Indiquez votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'Indiquez votre pays'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Indiquez votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder cette adresse',
                'attr' => [
                    'class' => 'btn-success w-100 my-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
