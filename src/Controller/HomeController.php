<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\HeroRepository;
use App\Repository\PersonnelRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name:'app_home')]
function index(HeroRepository $hero,
    AboutRepository $about,
    ServiceRepository $service,
    CategoryRepository $category,
    ArticleRepository $article,
    TestimonialRepository $testimonial,
    PersonnelRepository $personnel
): Response {

    return $this->render('pages/index.html.twig',
        [
            'heros' => $hero->findAll(),
            'abouts' => $about->findAll(),
            'services' => $service->findAll(),
            'categories' => $category->findAll(),
            'articles' => $article->findAll(),
            'articles_limit' => $article->findLimit(5),
            'testimonials' => $testimonial->findAll(),
            'personnels' => $personnel->findLimit(3),
            'date' => date('Y'),
        ]);
}
}
