<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/shop', name: 'app_shop')]
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
