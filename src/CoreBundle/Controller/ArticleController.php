<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Service\DeleteFormGenerator;
use CoreBundle\Service\OrderEntities;
/**
 * Article controller.
 *
 * @Route("admin/article")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="admin_article_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(DeleteFormGenerator $DeleteFormGenerator, Request $request, OrderEntities $orderEntities)
    {
        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository('CoreBundle:Article');

        //Reorder the articles with the ajax request
        if($request->isXmlHttpRequest()) {
          $articles = $orderEntities->order($articleRepository, "title");
          $em->flush();
        }

        //Get all the paths and pass it to the sorting form
        $paths = $em->getRepository("CoreBundle:Path")->getPathsWithModules();
        $sortingForm = $this->createForm('CoreBundle\Form\SortingType',null, ['choices'=>$paths, 'parentIndication' => true]);

        $sortingForm->handleRequest($request);
         if ($sortingForm->isSubmitted() && $sortingForm->isValid()) {
           //Get the module object returned by the form input of name sort
           $sortingModule = $sortingForm->getData()["sort"];
           $articles = $articleRepository->getArticlesImagesByModule($sortingModule);
         }
         else {
          $articles = $articleRepository->getArticlesWithCategoryModules();
         }

        $deleteForm = $DeleteFormGenerator->generateDeleteForms($articles, 'admin_article_delete');

        return $this->render('CoreBundle:Admin/Article:index.html.twig', array(
            'articles' => $articles,
            'delete_form' => $deleteForm,
            'sorting_form' => $sortingForm->createView()
        ));
    }

    /**
     * Creates a new article entity.
     *
     * @Route("/new", name="admin_article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('CoreBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            //If there is an image submitted in the form then persist it
            if($article->getImage() != null) {
              $em->persist($article->getImage());
            }
            $em->flush();

            return $this->redirectToRoute('admin_article_show', array('id' => $article->getId()));
        }

        return $this->render('CoreBundle:Admin/Article:new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}", name="admin_article_show")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('CoreBundle:Admin/Article:show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="admin_article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('CoreBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($article->getImage() !== null) {
              $this->getDoctrine()->getManager()->persist($article->getImage());
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_article_edit', array('id' => $article->getId()));
        }

        return $this->render('CoreBundle:Admin/Article:edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/{id}", name="admin_article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('admin_article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
