<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Path;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Service\DeleteFormGenerator;
use CoreBundle\Service\OrderEntities;

/**
 * Path controller.
 *
 * @Route("admin/path")
 */
class PathController extends Controller
{
    /**
     * Lists all path entities.
     *
     * @Route("/", name="admin_path_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(DeleteFormGenerator $DeleteFormGenerator, Request $request, OrderEntities $orderEntities)
    {
      $em = $this->getDoctrine()->getManager();
      $pathRepo = $em->getRepository('CoreBundle:Path');

      //Reorder the path with the ajax request
      if($request->isXmlHttpRequest()) {
        $paths = $orderEntities->order($pathRepo, "title");
        $em->flush();
      }

        $paths = $pathRepo->findBy([], ["dispatch"=>"ASC"]);

        $deleteForm = $DeleteFormGenerator->generateDeleteForms($paths, 'admin_path_delete');

        return $this->render('CoreBundle:Admin/Path:index.html.twig', array(
            'paths' => $paths,
            'delete_form' =>$deleteForm
        ));
    }

    /**
     * Creates a new path entity.
     *
     * @Route("/new", name="admin_path_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $path = new Path();
        $form = $this->createForm('CoreBundle\Form\PathType', $path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($path);
            $em->flush();

            return $this->redirectToRoute('admin_path_show', array('id' => $path->getId()));
        }

        return $this->render('CoreBundle:Admin/Path:new.html.twig', array(
            'path' => $path,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a path entity.
     *
     * @Route("/{id}", name="admin_path_show")
     * @Method("GET")
     */
    public function showAction(Path $path)
    {
        $deleteForm = $this->createDeleteForm($path);

        return $this->render('CoreBundle:Admin/Path:show.html.twig', array(
            'path' => $path,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing path entity.
     *
     * @Route("/{id}/edit", name="admin_path_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Path $path)
    {
        $deleteForm = $this->createDeleteForm($path);
        $editForm = $this->createForm('CoreBundle\Form\PathType', $path);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_path_edit', array('id' => $path->getId()));
        }

        return $this->render('CoreBundle:Admin/Path:edit.html.twig', array(
            'path' => $path,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a path entity.
     *
     * @Route("/{id}", name="admin_path_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Path $path)
    {
        $form = $this->createDeleteForm($path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($path);
            $em->flush();
        }

        return $this->redirectToRoute('admin_path_index');
    }

    /**
     * Creates a form to delete a path entity.
     *
     * @param Path $path The path entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Path $path)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_path_delete', array('id' => $path->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
