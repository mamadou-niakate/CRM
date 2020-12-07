<?php

namespace App\Controller\Admin;

use App\Entity\InteractionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InteractionTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InteractionType::class;
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
