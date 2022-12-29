<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Hero;
use App\Entity\Personnel;
use App\Entity\Service;
use App\Entity\Testimonial;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('pages/administrator/access/permission', name:'admin')]
function index(): Response
    {
    // return parent::index();

    // Option 1. You can make your dashboard redirect to some common page of your backend
    //
    // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
    // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

    // Option 2. You can make your dashboard redirect to different pages depending on the user
    //
    // if ('jane' === $this->getUser()->getUsername()) {
    //     return $this->redirect('...');
    // }

    // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
    // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
    //
    return $this->render('pages/admin/index.html.twig');
}



function configureDashboard(): Dashboard
    {
    return Dashboard::new ()
        ->setTitle('Kab\'s Famer');
}

function configureMenuItems(): iterable
    {
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
    yield MenuItem::linkToCrud('About', 'fas fa-list', About::class);
    yield MenuItem::linkToCrud('Acceuil', 'fas fa-list', Hero ::class);
    yield MenuItem::linkToCrud('category', 'fas fa-list', Category::class);
    yield MenuItem::linkToCrud('Article', 'fas fa-list', Article::class);
    yield MenuItem::linkToCrud('Service', 'fas fa-list', Service::class);
    yield MenuItem::linkToCrud('Temoignage', 'fas fa-list', Testimonial::class);
    yield MenuItem::linkToCrud('Personnel', 'fas fa-list', Personnel::class);
    yield MenuItem::linkToCrud('contact', 'fas fa-list', Contact::class);
}
}
