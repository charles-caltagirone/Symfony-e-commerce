<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="app_cart")
     */
    public function index(Cart $panier): Response
    {
        if ($this->getUser()) {
            return $this->render('cart/index.html.twig', [
                'panier' => $panier->getFull(),
            ]);
        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    /**
     * @Route("/panier/add/{id}", name="app_add")
     */
    public function add(Cart $panier, $id): Response
    {
        $panier->add($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/panier/decrease/{id}", name="app_decrease")
     */
    public function decrease(Cart $panier, $id): Response
    {
        $panier->decrease($id);

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/panier/delete/{id}", name="app_delete")
     */
    public function delete(Cart $panier, $id): Response
    {
        $panier->delete($id);

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/panier/remove", name="app_remove")
     */
    public function remove(Cart $panier): Response
    {
        $panier->remove();

        return $this->redirectToRoute('app_products');
    }
}
