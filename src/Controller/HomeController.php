<?php

namespace App\Controller;

use App\Entity\Personnel;
use App\Repository\AboutRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\HeroRepository;
use App\Repository\PersonnelRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name:'app_home')]
    public function index(HeroRepository $hero, 
                                            AboutRepository $about, 
                                            ServiceRepository  $service, 
                                            CategoryRepository $category, 
                                            ArticleRepository $article,
                                            TestimonialRepository $testimonial,
                                            PersonnelRepository $personnel
                                            ): Response
    {
        
        return $this->render('pages/index.html.twig', 
    [
        'heros' => $hero->findAll(),
        'abouts' => $about->findAll(),
        'services' => $service->findAll(),
        'categories' => $category->findAll(),
        'articles' => $article->findAll(),
        'testimonials' => $testimonial->findAll(),
        'personnels' => $personnel->findAll(),
        'date'=> date('Y')
    ] );
    }
}
