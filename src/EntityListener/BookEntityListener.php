<?php

namespace App\EntityListener;

use App\Entity\Book;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: Events::prePersist, entity: Book::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Book::class)]
class BookEntityListener
{
    public function __construct(private SluggerInterface $slugger) { }
    public function __invoke(Book $book) : void
    {
        $book->computeSlug($this->slugger);
    }
}