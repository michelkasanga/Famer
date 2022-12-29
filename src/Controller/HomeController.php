<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\HeroRepository;
use App\Repository\AboutRepository;
use App\Repository\ArticleRepository;
use App\Repository\ServiceRepository;
use App\Repository\CategoryRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TestimonialRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[Route('/', name:'app_home', methods:['GET','POST'])]
        public function index(
            Request $request,
            HeroRepository $hero,
            AboutRepository $about,
            ServiceRepository $service,
            CategoryRepository $category,
            ArticleRepository $article,
            TestimonialRepository $testimonial,
            PersonnelRepository $personnel,
            EntityManagerInterface $manager,
            PaginatorInterface $paginator
        ): Response {

            $produit = $paginator->paginate(
                $article->findAll(),
                $request->query->getInt('page', 1), /*page number*/
                2/*limit per page*/
            );

            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $contact = $form->getData();
                $contact->setRead(0);
                $manager->persist($contact);
                $manager->flush();
    
                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }

    
            return $this->render('pages/index.html.twig',
                [
                    'heros' => $hero->findAll(),
                    'abouts' => $about->findAll(),
                    'services' => $service->findAll(),
                    'categories' => $category->findAll(),
                    'articles' => $produit,
                    'articles_limit' => $article->findLimit(6),
                    'article_count' => count($article->findCount()),
                    'testimonials' => $testimonial->findAll(),
                    'personnels' => $personnel->findLimit(3),
                    'personnels_count' => count($personnel->findAll()),
                    'date' => date('Y'),
                    'form' => $form->createView()
                ]);
        }

}
