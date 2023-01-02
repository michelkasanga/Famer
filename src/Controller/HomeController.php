<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Contact;
use App\Form\CommandType;
use App\Form\ContactType;
use App\Repository\AboutRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ContactRepository;
use App\Repository\HeroRepository;
use App\Repository\PersonnelRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name:'app_home', methods:['GET', 'POST'])]
function index(
    Request $request,
    HeroRepository $hero,
    AboutRepository $about,
    ServiceRepository $service,
    CategoryRepository $category,
    ArticleRepository $article,
    TestimonialRepository $testimonial,
    PersonnelRepository $personnel,
    EntityManagerInterface $manager,
    PaginatorInterface $paginator,
    ContactRepository $contactRepository
): Response {
  
    $produit = $paginator->paginate(
        $article->findAll(),
        $request->query->getInt('page', 1), /*page number*/
        6/*limit per page*/
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
            'form' => $form->createView(),
            'contacts' => $contactRepository->findUnRead(),
            
        ]);
}

#[Route('/article/show/{id}', name:'app_article_show', methods:['GET', 'POST'])]
function show(Article $article, EntityManagerInterface $manager, ContactRepository $contactRepository, Request $request): Response
    {
      
    $contact = new Contact();
    $form = $this->createForm(CommandType::class, $contact);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $contact = $form->getData();
        $TotalPrice = $contact->getQuantity() * $article->getPrice();
        $contact->setRead(1)
            ->setSubject('commande de ' .$TotalPrice. ' FC<br> Produit : ' . $article->getName())
            ->setMessage('prix Unitaire :  ' . $article->getprice().' <br> Quantitée :  '. $contact->getQuantity())
            ->setImageName($article->getImageName());

        $manager->persist($contact);
        $manager->flush();

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
    return $this->render('article/show.html.twig', [
        'article' => $article,
        'form' => $form->createView(),
        'contacts' => $contactRepository->findUnRead(),
      
    ]);
}


#[Route('/read/{id}', name:'app_read', methods:['GET', 'POST'])]
public  function read(Contact $contact, EntityManagerInterface $manager, Request $request): Response
    {
        $contact->setRead(2);
        $manager->persist($contact);
        $manager->flush();
    return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
}


#[Route('/read/message/{id}', name:'app_read_message', methods:['GET', 'POST'])]
public  function readMessage(Contact $contact, EntityManagerInterface $manager, Request $request): Response
    {
        $contact->setRead(3);
        $manager->persist($contact);
        $manager->flush();
    return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
}
}
