<?php

namespace App\Controller;

use App\Entity\Adresses;
use App\Entity\User;
use App\Form\AdressesType;
use App\Form\InformationsChangeUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Mes commandes
    // Mes adresses
    // Edit mdp
    // Edit adresses

    /**
     * @Route("/profil", name="app_user")
     */
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->render('user/index.html.twig');
        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    /**
     * @Route("/profil/editer-informations", name="app_edit_user")
     */
    public function editUser(Request $request): Response
    {
        if ($this->getUser()) {
            $user = $this->getUser();
            $form = $this->createForm(InformationsChangeUserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->flush();

                return $this->redirectToRoute('app_user');
            }

            return $this->render('user/editUser.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    /**
     * @Route("/profil/ajout-adresse", name="app_new_adress")
     */
    public function addAdress(Request $request): Response
    {
        $adress = new Adresses();
        $form = $this->createForm(AdressesType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adress = $form->getData();
            $adress->setUser($this->getUser()); // Associer le user à l'adresse

            $this->entityManager->persist($adress);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/newAdress.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/modifier-adresse/{id}", name="app_edit_adress")
     */
    public function editAdress(Request $request, $id): Response
    {
        $idAdress = $this->entityManager->getRepository(Adresses::class)->find($id);

        if (!$idAdress || $idAdress->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_user');
        }

        $form = $this->createForm(AdressesType::class, $idAdress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_user');
        }
        return $this->render('user/editAdress.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/supprimer-adresse/{id}", name="app_delete_adress")
     */
    public function deleteAdress($id): Response
    {
        $idAdress = $this->entityManager->getRepository(Adresses::class)->find($id);

        if ($idAdress && $idAdress->getUser() == $this->getUser()) {
            $this->entityManager->remove($idAdress);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_user');
    }
}
