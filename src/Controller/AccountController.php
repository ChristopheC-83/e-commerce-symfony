<?php

namespace App\Controller;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }
    #[Route('/modifier_mpd', name: 'app_account_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
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
            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a bien été modifié');
        }

        return $this->render('account/password.html.twig', [
            'modifyPwd' => $form->createView()


        ]);
    }
}
