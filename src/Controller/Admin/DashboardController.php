<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Products;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN') == false) {
            return $this->redirectToRoute('app_home');
        } else {
            return parent::index();
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MySite');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Tous les produits', 'fa fa-box-open', Products::class);
        yield MenuItem::linkToCrud('Tous les users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Les catégories', 'fa fa-tag', Category::class);
    }
}
