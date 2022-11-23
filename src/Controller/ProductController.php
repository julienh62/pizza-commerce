<?php

namespace App\Controller;

use App\Cart\CartHandler;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_products')]
    public function index(ProductRepository $productRepository, RequestStack $request, CartHandler $cartHandler): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy([], ['price' => 'ASC']),
            'cart' => $request->getSession()->get('cart', []),
            'total' => $cartHandler->total()
        ]);
    }
}