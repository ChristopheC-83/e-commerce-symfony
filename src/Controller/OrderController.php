<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{

    // 1ere étape du tunnel d'achat
    //  choix addresse livraison
    // choix transporteur

    #[Route('/commande/livraison', name: 'app_order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig');
    }
}
