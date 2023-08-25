<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    /** appel de Doctrine */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class); // récupérer le formulaire du dossier form

        $form->handleRequest($request); // récupère la requête

        if ($form->isSubmitted() && $form->isValid()) { // vérification du form, comme isset en natif
            $user = $form->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword()); // salage du mdp
            $user->setPassword($hashedPassword);


            $this->entityManager->persist($user); // équivalent du prepare PDO
            $this->entityManager->flush(); // équivalent du execute PDO

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
