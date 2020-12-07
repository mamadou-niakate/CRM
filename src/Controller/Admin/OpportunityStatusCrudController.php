<?php

namespace App\Controller\Admin;

use App\Entity\OpportunityStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OpportunityStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OpportunityStatus::class;
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
