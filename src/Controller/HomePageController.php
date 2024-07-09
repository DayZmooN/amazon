<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les articles
        $articleRepository = $entityManager->getRepository('App\Entity\Article');
        $articles = $articleRepository->findAll();

        return $this->render('home_page/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
