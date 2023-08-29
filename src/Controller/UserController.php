<?php

namespace App\Controller;

use App\Entity\User;
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
     * @Route("/profil/", name="app_user")
     */
    public function index(): Response
    {
        // $user = $this->entityManager->getRepository(User::class)->findOneBySlug($slug);
        // dd($user);
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
}
