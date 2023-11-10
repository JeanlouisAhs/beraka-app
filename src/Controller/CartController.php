<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/my-cart', name: 'card_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getTotal(),
        ]);
    }
    #[Route('/my-cart/add/{id<\d+>}', name: 'card_add')]
    public function addToRoute(CartService $cartService, int $id): Response
    {
        $cartService->addToCart($id);
       return $this->redirectToRoute('card_index');
    }

    #[Route('/my-cart/remove-all', name: 'card_remove_all')]
    public function removeAll(CartService $cartService): Response
    {
        $cartService->removeAll();
        return $this->redirectToRoute('app_shop');
    }
}
