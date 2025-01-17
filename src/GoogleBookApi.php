<?php

namespace App;

use App\Entity\Book;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class GoogleBookApi
{
    public function __construct(private readonly HttpClientInterface $client)
    {
    }
    public function getBooksByAuthor(Book $book): array
    {
        $url ='https://www.googleapis.com/books/v1/volumes';
        $response = $this->client->request('GET', $url, [
            'query' => [
                'q' => $book->getAuthor().' ' . $book->gettitle()
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to fetch data from Google Books API');
        }
        return $response->toArray();
    }
}