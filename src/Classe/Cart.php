<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{

    public function __construct(private RequestStack $requestStack)
    {
    }

    // Ajout d'un produit au panier
    public function add($product)
    {
        // appel session
        $cart = $this->getCart();
        // qtt + 1 
        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()]['qtt']++;
            $this->requestStack->getSession()->set('cart', $cart);
        } else {
            $cart[$product->getId()] = [
                'object' => $product,
                'qtt' => 1
            ];
            $this->requestStack->getSession()->set('cart', $cart);
        }

        // Créer session cart
        $this->requestStack->getSession()->set('cart', $cart);
        // dd($this->requestStack->getSession()->get('cart'));
    }

    //  on retire un produit du panier
    public function decrease($id)
    {
        $cart = $this->getCart();

        if ($cart[$id]['qtt'] > 1) {
            $cart[$id]['qtt']--;
        } else {
            unset($cart[$id]);
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    // on retourne le nombre total de produits au panier
    public function fullQtt()
    {

        $cart = $this->getCart();
        $qtt = 0;
        if ($cart) {
            foreach ($cart as $product) {
                $qtt += $product['qtt'];
            }
        }

        // dd($qtt);
        // return $qtt;
        return $qtt;
    }

    //  on retour le total du panier en hors taxe
    public function getTotal()
    {
        $cart = $this->getCart();
        $total = 0;
        if ($cart) {
            foreach ($cart as $product) {
                $total += $product['object']->getPrice() * $product['qtt'];
            }
        }
        return $total;
    }

    //  récupération de la TVA total du panier
    public function getTotalTVA()
    {
        $cart = $this->getCart();
        $total = 0;
        if ($cart) {
            foreach ($cart as $product) {
                $total += $product['object']->getPrice() * $product['qtt'] * 0.2;
            }
        }
        return $total;
    }

    //  récupération du montant total du panier en TTC
    public function getTotalWt()
    {
        $cart = $this->getCart();
        $total = 0;
        if ($cart) {
            foreach ($cart as $product) {
                $total += $product['object']->getPriceWt() * $product['qtt'];
            }
        }
        return $total;
    }

    // récupération du contenu du panier
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
    public function deleteCart()
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    // vidage total du panier
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }


}