<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]

    // on injecte la dépendance AuthenticationUtils
    // mais on l'utilise à travers une variable $authenticationUtils
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // gestion erreur de connexion
        $error = $authenticationUtils->getLastAuthenticationError();



        // gerer la dernier user/email pour garder le champ rempli si mauvais password
        $lastUsername = $authenticationUtils->getLastUsername();



        return $this->render('login/index.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/deconnexion', name: 'app_logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


}
