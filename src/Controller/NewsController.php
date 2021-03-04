<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    /**
     * @Route("/", name="news")
     */
    public function index(NewsRepository $repo): Response
    {
        // $news=$repo->findAll();
        // dd($news);

        // Ma méthode
        // $lastNews = $repo->findBy(array('status' => 'Published'),array('createdAt' => 'ASC'),5 ,0);
        $lastNews = $repo->findLastNews(5);
        // dd($lastNews);

        return $this->render('news/index.html.twig', [
            'lastNews' => $lastNews
        
        ]);

    }

    /**
     * affichage d'un article 
     * @Route("/view/{id}", name="view")
     */


public function view(News $news){

    // dd($news);

    return $this->render('news/view.html.twig', [
        'news' =>$news
    ]);

  

}


}
