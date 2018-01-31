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

        $articles = $articleRepository->getArticlesImagesAndCategories();

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

    /**
     * @Route("/admin/index", name ="adminIndex")
     */
    public function adminAction()
    {
      return $this->render('CoreBundle:Admin:adminIndex.html.twig');
    }

    /**
     * @Route("/parcours", name ="parcours")
     */
    public function parcoursAction()
    {
      $em  = $this->getDoctrine()->getManager();
      $pathRepository = $em->getRepository('CoreBundle:Path');

      $paths = $pathRepository->getPathsWithModules();

      return $this->render('CoreBundle:Article:parcours.html.twig', ["paths" => $paths]);
    }

    /**
     * @Route("{pathTitle}/modules", name ="modules")
     */
    public function modulesAction($pathTitle)
    {
      $em  = $this->getDoctrine()->getManager();
      $modulesRepository = $em->getRepository('CoreBundle:Module');

      $pathRepository = $em->getRepository('CoreBundle:Path');
      $path = $pathRepository->findOneBy(["title"=>$pathTitle]);

      $modules = $modulesRepository->findBy(["path" => $path->getId()]);

      return $this->render('CoreBundle:Article:modules.html.twig', [
        "modules" => $modules,
        "path" => $path
      ]);
    }
}
