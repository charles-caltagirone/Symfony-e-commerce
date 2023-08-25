<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('fullName', 'Nom et prénom')
                ->hideOnForm(),

            TextField::new('lastname', 'Nom')
                ->hideOnIndex(),

            TextField::new('firstname', 'Prénom')
                ->hideOnIndex(),

            EmailField::new('email'),

            DateField::new('birthday_date', 'Date de naissance')
                ->setFormat('medium'),

        ];
    }
}
