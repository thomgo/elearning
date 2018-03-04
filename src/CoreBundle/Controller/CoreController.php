<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CoreBundle\Entity\Path;
use CoreBundle\Entity\Module;

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

        $article = $articleRepository->getSingleArticle($id);
        dump($article);

        return $this->render('CoreBundle:Article:single.html.twig', ["article"=>$article]);
    }


    /**
    * @Route("/articles/{category}.{format}", requirements={"category" : "[a-z]+"}, name="articlesCategory")
    */
    public function CategoryAction($category, $format = "html") {

      $em  = $this->getDoctrine()->getManager();
      $categoryRepository = $em->getRepository('CoreBundle:Category');

      $categoryArticles = $categoryRepository->getCategoryWithArticles($category);

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
     * @Route("{title}/modules", name ="modules")
     * @ParamConverter("path", class="CoreBundle:Path")
     */
    public function modulesAction(Path $path)
    {
      $em  = $this->getDoctrine()->getManager();
      $modulesRepository = $em->getRepository('CoreBundle:Module');

      $modules = $modulesRepository->getModulesWithArticles($path->getId());

      return $this->render('CoreBundle:Article:modules.html.twig', [
        "modules" => $modules,
        "path" => $path
      ]);
    }

    /**
     * @Route("{title}/articles", name ="moduleArticles")
     * @ParamConverter("module", class="CoreBundle:Module")
     */
    public function moduleArticles(Module $module, Request $request)
    {
      //get the previous page for the back link in  view
      $referer = $request->headers->get('referer');

      $em  = $this->getDoctrine()->getManager();
      $articlesRepository = $em->getRepository('CoreBundle:Article');

      $articles = $articlesRepository->getArticlesImagesByModule($module->getId());

      return $this->render('CoreBundle:Article:moduleArticles.html.twig', [
        "module" => $module,
        "articles" => $articles,
        "previous_page" => $referer
      ]);
    }
}
