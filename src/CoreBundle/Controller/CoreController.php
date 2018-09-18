<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CoreBundle\Entity\Path;
use CoreBundle\Entity\Module;
use CoreBundle\Entity\Test;

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
    public function parcoursAction(Request $request)
    {
      //Retrieve the paths entities with the associated modules
      $em  = $this->getDoctrine()->getManager();
      $pathRepository = $em->getRepository('CoreBundle:Path');

      $paths = $pathRepository->getPathsWithModules();

      //Loop through path entities, create both selection form and views stored in arrays
      foreach ($paths as $path) {
        $startPathType = $this->createForm('CoreBundle\Form\StartPathType', null, ["index" => $path->getId()]);
        $startPathTypes[] = $startPathType;
        $startPathTypesViews[] = $startPathType->createView();
      }

      //If the user is logged the forms submission is handled
      if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        foreach ($startPathTypes as $startPathType) {
          $startPathType->handleRequest($request);
        }

        if ($startPathType->isSubmitted() && $startPathType->isValid()) {
          //Get the current user and the pathid he clicked on
          $user = $this->getUser();
          $pathId = $startPathType->getData()["token"];

          //Retrieve the path, add it to the user and save it in database
          $path = $pathRepository->find($pathId);
          $user->addPath($path);
          $em->persist($user);
          $em->flush();

          //Redirect to the appropriate modules route
          return $this->redirectToRoute('modules', array('title' => $path->getTitle()));
        }
      }

      //Response with the selection forms if no form ahs been sent
      return $this->render('CoreBundle:Article:parcours.html.twig', [
        "paths" => $paths,
        "startPathTypes" => $startPathTypesViews
      ]);
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

    /**
     * @Route("test/{id}", name ="test")
     * @ParamConverter("test", class="CoreBundle:Test")
     */
    public function testAction(Test $test) {
      return $this->render('CoreBundle:Article:test.html.twig', [
        'test' => $test
      ]);
    }
}
