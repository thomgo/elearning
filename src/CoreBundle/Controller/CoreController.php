<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
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


    /**
    * @Route("/articles/{category}.{format}", requirements={"category" : "[a-z]+"}, name="articlesCategory")
    */
    public function CategoryAction($category, $format = "html") {

      $em  = $this->getDoctrine()->getManager();
      $categoryRepository = $em->getRepository('CoreBundle:Category');

      $query = $categoryRepository->createQueryBuilder('c')
      ->where('c.name = :category')
      ->setParameter('category', $category)
      ->leftJoin("c.articles", "art")
      ->addSelect("art")
      ->leftJoin("art.image", "img")
      ->addSelect("img")
      ->getQuery();

      $categoryArticles = $query->getResult();

      return $this->render('CoreBundle:Article:articleCategory.html.twig', ["categoryArticles"=>$categoryArticles]);
    }
}
