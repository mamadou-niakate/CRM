<?php

namespace App\Controller\Admin;

use App\Entity\UserStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserStatus::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
