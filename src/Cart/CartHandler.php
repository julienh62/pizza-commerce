<?php

namespace App\Cart;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;

class CartHandler
{
    private $session;

    public function __construct(private RequestStack $request)
    {
        $this->session = $request->getSession();
    }

    public function total()
    {
        $cart = $this->request->getSession()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['product']->getPrice() / 100;
        }

        return $total;
    }

    public function add(Product $product): void
    {
        $id = $product->getId();
        $cart = $this->session->get('cart', []);
        $quantity = isset($cart[$id]) ? $cart[$id]['quantity'] + 1 : 1;

        $cart[$product->getId()] = [
            'product' => $product,
            'quantity' => $quantity
        ];

        $this->session->set('cart', $cart);
    }

    public function sub(Product $product): void
    {
        $id = $product->getId();
        $cart = $this->session->get('cart', []);
        $quantity = isset($cart[$id]) ? $cart[$id]['quantity'] - 1 : null;

        if($quantity <1) {
            unset($cart[$id]);
        }

        if($quantity > 0) {
            $cart[$product->getId()] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }

        $this->session->set('cart', $cart);
    }

    public function delete(Product $product): void
    {
        $cart = $this->session->get('cart', []);
        $id = $product->getId();

        if($cart[$id]) {
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    }

    public function empty()
    {
        $this->session->remove('cart');
    }

}


//        $cart = [
//            1 => ['produit' => $product1, 'quantity' => 1],
//            3 => ['produit' => $product3, 'quantity' => 2],
//            5 => ['produit' => $product2, 'quantity' => 4]
//        ];