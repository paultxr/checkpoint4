<?php

namespace App\Controller\Admin;

use App\Entity\Job;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Techno;
use App\Entity\Mission;
use App\Controller\Admin\JobCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
  public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(JobCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoCrud('User', 'fa fa-user', User::class);
        yield MenuItem::linktoCrud('Job', 'fa fa-briefcase', Job::class);
        yield MenuItem::linktoCrud('Mission', 'fa fa-archive', Mission::class);
        yield MenuItem::linktoCrud('Role', 'fa fa-user-secret', Role::class);
        yield MenuItem::linktoCrud('Techno', 'fa fa-laptop', Techno::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
