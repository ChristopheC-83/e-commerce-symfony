<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{

    public function __construct(private RequestStack $requestStack)
    {
    }

    public function add($product)
    {
        // appel session
        $cart = $this->requestStack->getSession()->get('cart');
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

    public function decrease($id)
    {
        $cart = $this->requestStack->getSession()->get('cart');

        if ($cart[$id]['qtt'] > 1) {
            $cart[$id]['qtt']--;
        } else {
            unset($cart[$id]);
        }
        
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }

    public function deleteCart()
    {
        return $this->requestStack->getSession()->remove('cart');
    }
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }


}