<?php

namespace App\Controller;

use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TagController extends AbstractController
{
    /**
     * @Route("/tag/{name}", name="show_tag")
     * @ParamConverter("tag", class="App\Entity\Tag")
     */
    public function index(Tag $tag) :Response
    {
        return $this->render('tag/index.html.twig', [
            'tag' => $tag,
        ]);
    }
}
