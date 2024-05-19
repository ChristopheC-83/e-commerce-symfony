<?php

namespace App\Controller\Account;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;



class PasswordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/modifier_mpd', name: 'app_account_modify_pwd')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

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

        return $this->render('account/password/index.html.twig', [
            'modifyPwd' => $form->createView()


        ]);
    }
}