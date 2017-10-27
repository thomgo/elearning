<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * @Route("/", name ="default")
     */
    public function indexAction()
    {

        $em  = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository('CoreBundle:Article');

        $query = $articleRepository->createQueryBuilder('a')
        ->orderBy("a.id", "DESC")
        ->setMaxResults(5)
        ->leftJoin("a.image", "img")
        ->addSelect("img")
        ->leftJoin("a.categories", "cat")
        ->addSelect("cat")
        ->getQuery();

        $articles = $query->getResult();

        return $this->render('CoreBundle:Article:index.html.twig', ["articles"=>$articles]);
    }

    /**
    * @Route("/article/{id}.{format}", requirements={"id" : "\d+"}, name="single")
    */
    public function SingleAction($id = 1, $format = "html")
    {
        $em  = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository('CoreBundle:Article');

        $article = $articleRepository->findOneById($id);

        return $this->render('CoreBundle:Article:single.html.twig', ["article"=>$article]);
    }

}
