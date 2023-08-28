<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/produits", name="app_products")
     */
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Products::class)->findAll();
        // dd($products);

        return $this->render('products/index.html.twig', [
            'products' => $products,
        ]);
    }
    
    /**
     * @Route("/produits/{slug}", name="app_details")
     */
    public function details($slug): Response
    {
        $product = $this->entityManager->getRepository(Products::class)->findOneBySlug($slug);
        // dd($products);

        return $this->render('products/details.html.twig', [
            'product' => $product,
        ]);
    }
}
