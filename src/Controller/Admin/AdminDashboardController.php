<?php

namespace App\Controller\Admin;

use App\Entity\Interaction;
use App\Entity\InteractionStatus;
use App\Entity\InteractionType;
use App\Entity\LeadStatus;
use App\Entity\Opportunity;
use App\Entity\OpportunityStatus;
use App\Entity\SalePhase;
use App\Entity\User;
use App\Entity\UserRole;
use App\Entity\UserStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Easy Crm');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fas fa-users', User::class),
            MenuItem::linkToCrud('Roles', 'fas fa-users', UserRole::class),
            MenuItem::linkToCrud('Status ', 'fas fa-users', UserStatus::class),

            MenuItem::section('Opportunities'),
            MenuItem::linkToCrud('Status', 'fas fa-business-time', OpportunityStatus::class),

            MenuItem::section('Leads'),
            MenuItem::linkToCrud('Status', 'fas fa-user-tie', LeadStatus::class),

            MenuItem::section('Sales'),
            MenuItem::linkToCrud('Phases', 'fas fa-store', SalePhase::class),

            MenuItem::section('Activities/Tasks'),
            MenuItem::linkToCrud('Status', 'fas fa-inbox', InteractionStatus::class),
            MenuItem::linkToCrud('Type', 'fas fa-inbox', InteractionType::class)
        ];
    }
}
