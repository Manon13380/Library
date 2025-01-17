<?php

namespace App\Controller;

use App\Entity\Book;
use App\GoogleBookApi;
use App\Form\BookFormType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class BookController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(Request $request, BookRepository $bookRepository, Security $security): Response
    {

        $books = $bookRepository->findAll();
        $user = $security->getUser();

        if ($user) {
            $userRoles = $user->getRoles();
        } else {
            $userRoles = [];
        }

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'roles' => $userRoles
        ]);
    }

    #[Route('/addBook', name: 'addBook')]
    public function addBook(
        Request $request,
        GoogleBookApi $googleBookApi,
        EntityManagerInterface $entityManager,
        Security $security,
    ): Response {

        $user = $security->getUser();

        if ($user) {
            $userRoles = $user->getRoles();
        } else {
            $userRoles = [];
        }
        $book = new Book();
        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $googleBookApi->getBooksByAuthor($book);
            $bookApi = $data['items'][0]['volumeInfo'];
            if (isset($bookApi['title'])) {
                $book->setTitle($bookApi['title']);
            }
            if (isset($bookApi['authors'][0])) {
                $book->setAuthor($bookApi['authors'][0]);
            }
            if (isset($bookApi['publishedDate'])) {
                $book->setPublication($bookApi['publishedDate']);
            }
            if (isset($bookApi['industryIdentifiers'][0]['identifier'])) {
                $book->setISBN($bookApi['industryIdentifiers'][0]['identifier']);
            }
            if (isset($bookApi['imageLinks']['smallThumbnail'])) {
                $book->setImage($bookApi['imageLinks']['smallThumbnail']);
            }
            if (isset($bookApi['description'])) {
                $book->setDescription($bookApi['description']);
            }
            if (isset($bookApi['categories'])) {
                $book->setGenre($bookApi['categories']);
            }
            $book->setUserName($user);
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('book/addBook.html.twig', [
            'roles' => $userRoles,
            'bookForm' => $form
        ]);
    }


    #[Route('/book/{slug}', name: 'book')]
    public function show( String $slug, BookRepository $bookRepository, Security $security): Response
    {

        $book = $bookRepository->findOneBy(['slug' => $slug]);
        $user = $security->getUser();

        if ($user) {
            $userRoles = $user->getRoles();
        } else {
            $userRoles = [];
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'roles' => $userRoles
        ]);
    }

    #[Route('/book/{slug}/delete', name: 'bookDelete')]
    public function delete( String $slug, BookRepository $bookRepository, EntityManagerInterface $entityManager): Response
    {

        $book = $bookRepository->findOneBy(['slug' => $slug]);
            $entityManager->remove($book);
            $entityManager->flush();

        return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
    }
}
