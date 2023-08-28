<?php

namespace App\Classe;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{

    private $entityManager;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function getFull()
    {
        $panierComplete = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Products::class)->find($id);
                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }
                $panierComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }

        return $panierComplete;
    }

    public function add($id)
    {
        $panier = $this->requestStack->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        return $this->requestStack->getSession()->set('panier', $panier);
    }

    public function get()
    {
        return $this->requestStack->getSession()->get('panier');
    }

    public function remove()
    {
        return $this->requestStack->getSession()->remove('panier');
    }

    public function delete($id)
    {
        $panier = $this->requestStack->getSession()->get('panier', []);

        unset($panier[$id]);

        return $this->requestStack->getSession()->set('panier', $panier);
    }

    public function decrease($id)
    {
        $panier = $this->requestStack->getSession()->get('panier', []);

        if ($panier[$id] > 1) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);            
        }

        return $this->requestStack->getSession()->set('panier', $panier);
    }
}
