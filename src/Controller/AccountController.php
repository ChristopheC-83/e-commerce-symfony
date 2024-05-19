<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressUserType;
use App\Form\PasswordUserType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;


    }


    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }



    #[Route('/modifier_mpd', name: 'app_account_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        // test 

        $user = $this->getUser();
        // dd($user);

        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $passwordHasher
        ]);

        // formulaire ecoute si soumission
        $form->handleRequest($request);

        // est il soumis et valide ?
        if ($form->isSubmitted() && $form->isValid()) {
            // debug
            // dd($form->getData());
            // persist pas utile on modifie, on ne crée pas une donnée
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a bien été modifié');
        }

        return $this->render('account/password.html.twig', [
            'modifyPwd' => $form->createView()


        ]);
    }

    #[Route('/compte/adresses', name: 'app_account_addresses')]
    public function addresses(): Response
    {
        return $this->render('account/addresses.html.twig');
    }
    #[Route('/compte/adresses/delete/{id}', name: 'app_account_address_delete')]
    public function addressDelete($id, AddressRepository $addressRepository): Response
    {

        // Récupération de l'adresse
        $address = $addressRepository->findOneById($id);

            // L'addresse existe ?
            // L'adresse appartient bien à cet utilisateur ?
            if(!$address OR $address->getUser() != $this->getUser()){
                $this->addFlash('warning', 'Adresse non répertoriée !');
                return $this->redirectToRoute('app_account_addresses');
            }

            $this->addFlash('info', 'Adresse supprimée !');
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        return $this->redirectToRoute('app_account_addresses');
    }

    // Ajout d'une adresse si pas d'id
    // Modification d'une adresse si id
    #[Route('/compte/adresse/ajouter/{id}', name: 'app_account_address_form', defaults: ['id' => null])]
    public function addressForm(Request $request, $id, AddressRepository $addressRepository): Response
    {

        if ($id) {
            $address = $addressRepository->findOneById($id);
            //  L'addresse existe ?
            // L'adresse appartient bien à cet utilisateur ?
            if(!$address OR $address->getUser() != $this->getUser()){
                $this->addFlash('warning', 'Adresse non répertoriée !');
                return $this->redirectToRoute('app_account_addresses');
            }
        } else {
            $address = new Address();
            $address->setUser($this->getUser());
        }

        $form = $this->createForm(AddressUserType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre adresse a bien été sauvegardée ! ');

            return $this->redirectToRoute('app_account_addresses');
        }

        return $this->render('account/addressForm.html.twig', [
            'addressForm' => $form
        ]);
    }

}