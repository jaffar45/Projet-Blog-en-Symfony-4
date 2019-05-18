<?php
// src/Controller/BlogController.php
namespace App\Controller;


use App\Entity\Category;
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
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/show/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @return Response A response instance
     */
    public function show(string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-"));

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.');
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

//    /**
//     * Getting articles from a category
//     *
//     *
//     * @Route("/blog/category/{categoryName}", name="show_category")
//     * @return Response A response instance
//     */
//    public function showByCategory(string $categoryName): Response
//    {
//        $category = $this->getDoctrine()
//            ->getRepository(Category::class)
//            ->findOneByName($categoryName);
//
//        if (!$categoryName) {
//            throw $this->createNotFoundException(
//                'No article found in category\'s table.');
//        }
//
//        $articles = $this->getDoctrine()
//           ->getRepository(Article::class)
//           ->findBy(['category' => $category]);
//
//
//        return $this->render(
//            'blog/category.html.twig',
//            ['category' => $category,
//                'articles' => $articles,
//            ]);
//    }

//    /**
//     * Getting articles from a category
//     *
//     *
//     * @Route("/blog/category/{categoryName}", name="show_category")
//     * @return Response A response instance
//     */
//    public function showByCategory(string $categoryName): Response
//    {
//        $category = $this->getDoctrine()
//            ->getRepository(Category::class)
//            ->findOneByName($categoryName)
//            ->getArticles();
//
//        if (!$categoryName) {
//            throw $this->createNotFoundException(
//                'No article found in category\'s table.');
//        }
//
//        return $this->render(
//            'blog/category.html.twig',
//            ['category' => $category,
//                ]);
//    }

    /**
     * Getting articles from a category
     *
     *
     * @Route("/blog/category/{category}", name="show_category")
     * @param Category $category
     * @return Response A response instance
     */
    public function showByCategory(Category $category): Response
    {
        $category->getArticles();

        if (!$category) {
            throw $this->createNotFoundException('No article found in category\'s table.');
        }

        return $this->render('blog/category.html.twig', ['category' => $category,]);
    }

}
