<?php

namespace App\Controller\Admin;

use App\Entity\LeadStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LeadStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LeadStatus::class;
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
