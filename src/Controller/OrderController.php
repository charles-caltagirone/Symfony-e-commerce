<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/commande", name="app_order")
     */
    public function index(Cart $panier): Response
    {
        if (!$this->getUser()->getAdresses()->getValues()) {
            return $this->redirectToRoute('app_new_adress');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);        // lie le formulaire au user connecté

        return $this->render('order/index.html.twig', [
            'panier' => $panier->getFull(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="app_recap_order", methods:"POST")
     */
    // public function addOrder(Request $request): Response
    // {

    //     $form = $this->createForm(OrderType::class, null, [
    //         'user' => $this->getUser(),
    //     ]);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // $form->getData();
    //         dd($form->getData());

    //         return $this->render('order/newOrder.html.twig');
    //     }
    // }
}
