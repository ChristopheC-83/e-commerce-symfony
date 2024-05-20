<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
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
        $addresses = $this->getUser()->getAddresses();

        if (count($addresses) == 0) {
            $this->addFlash('warning', 'Vous devez ajouter une adresse pour passer commande');
            return $this->redirectToRoute('app_account_address_form');
        }

        $form = $this->createForm(OrderType::class, null, [
            'addresses' => $addresses,
        ]);


        return $this->render('order/index.html.twig', [
            'deliverForm' => $form->createView()

        ]);
    }
}
