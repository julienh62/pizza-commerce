<?php

namespace App\Controller;

use App\Cart\CartHandler;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository, private CartHandler $cartHandler) {}

    #[Route('/cart/add/{id<[0-9]+>}', name:'app_cart_add')]
    public function add(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if(!$product) {
            throw $this->createNotFoundException('Ce produit n\'existe pas.');
        }

        $this->cartHandler->add($product);

        return $this->redirectToRoute('app_products');
    }

    #[Route('/cart/sub/{id<[0-9]+>}', name:'app_cart_sub')]
    public function sub(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if(!$product) {
            throw $this->createNotFoundException('Ce produit n\'existe pas.');
        }

        $this->cartHandler->sub($product);

        return $this->redirectToRoute('app_products');
    }

    #[Route('/cart/delete/{id<[0-9]+>}', name:'app_cart_delete')]
    public function delete(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if(!$product) {
            throw $this->createNotFoundException('Ce produit n\'existe pas.');
        }

        $this->cartHandler->delete($product);

        return $this->redirectToRoute('app_products');
    }

    #[Route('/cart/empty', name:'app_cart_empty')]
    public function empty(RequestStack $request): Response
    {
        $this->cartHandler->empty();

        return $this->redirectToRoute('app_products');
    }

}