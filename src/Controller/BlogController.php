<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;


class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/blog", name="blog_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }


    /**
     * @Route("blog/show/{slug}", requirements={"slug"="^[a-z0-9](-?[a-z0-9])*$"}, name="blog_show")
     */

    public function show($slug ='article sans titre')
    {
        return $this->render('blog/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
        ]);
    }
}
