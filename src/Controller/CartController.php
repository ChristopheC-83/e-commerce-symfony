<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getCart()
        ]);
    }
    #[Route('/cart/delete', name: 'app_cart_delete')]
    public function delete(Cart $cart): Response
    {
        $cart->deleteCart();
        $this -> addFlash(
            'success', "Panier vidé."
        );
        // dd($cart->getCart());

        return $this->render('cart/index.html.twig');
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository): Response
    {
        // dd($id);
        // panier en DB, pas pertinent
        // on va mettre dans une session
        $product = $productRepository->findOneById($id);
        $cart->add($product);

        $this -> addFlash(
            'success', "Produit ajouté au panier."
        );

        return $this->redirectToRoute('app_product', [
            'slug' => $product->getSlug(),
        ]);


    }
}
