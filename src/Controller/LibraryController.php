<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class LibraryController extends AbstractController
{
    /**
     * @Route("/books", name="books_get")
     */
    public function list(Request $request, BookRepository $bookRepository){
        $title = $request->get('title', 'Alegria');
        $books = $bookRepository->findAll();
        $arr = [];
        foreach ($books as $book) {
            $arr[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'image' => $book->getImage()
            ];
        }
        $response = new JsonResponse();
        $response->setData([
            'succes'=> true,
            'data'=>$arr
        ]);
        return $response;
    }

        /**
     * @Route("/book/create", name="create_book")
     */
    public function createBook(Request $request, EntityManagerInterface $em){
        
        $book = new Book();
        $response = new JsonResponse();
        $title = $request->get('title', null);
        if(empty($title)){
            $response->setData([
                'succes'=> false,
                'error'=> 'Title cannot be empty',
                'data'=>null
            ]);
            return $response;
        }

        $book->setTitle($title);
        $book->setImage(null);
        $em->persist($book);
        $em->flush();
        $response = new JsonResponse();
        $response->setData([
            'succes'=> true,
            'data'=>[
                [
                    'id'=>$book->getId(),
                    'title'=> $book->getTitle(),
                ]
            ]
        ]);
        return $response;
    }
}