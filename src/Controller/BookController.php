<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class BookController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(BookRepository $bookRepository): Response
    {

        $books = $bookRepository->findAll();
        
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
}
