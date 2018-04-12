<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Service\DeleteFormGenerator;

/**
 * Test controller.
 *
 * @Route("admin/test")
 */
class TestController extends Controller
{
    /**
     * Lists all test entities.
     *
     * @Route("/", name="admin_test_index")
     * @Method("GET")
     */
    public function indexAction(DeleteFormGenerator $DeleteFormGenerator)
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository('CoreBundle:Test')->findAll();

        $deleteForm = $DeleteFormGenerator->generateDeleteForms($tests, 'admin_test_delete');

        return $this->render('CoreBundle:Admin/Test:index.html.twig', array(
            'tests' => $tests,
            'delete_form' =>$deleteForm
        ));
    }

    /**
     * Creates a new test entity.
     *
     * @Route("/new", name="admin_test_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $test = new Test();
        $form = $this->createForm('CoreBundle\Form\TestType', $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          dump($test);
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($test);
            // $em->flush();

            //return $this->redirectToRoute('admin_test_show', array('id' => $test->getId()));
        }

        return $this->render('CoreBundle:Admin/Test:new.html.twig', array(
            'test' => $test,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a test entity.
     *
     * @Route("/{id}", name="admin_test_show")
     * @Method("GET")
     */
    public function showAction(Test $test)
    {
        $deleteForm = $this->createDeleteForm($test);

        return $this->render('CoreBundle:Admin/Test:show.html.twig', array(
            'test' => $test,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing test entity.
     *
     * @Route("/{id}/edit", name="admin_test_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Test $test)
    {
        $deleteForm = $this->createDeleteForm($test);
        $editForm = $this->createForm('CoreBundle\Form\TestType', $test);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_test_edit', array('id' => $test->getId()));
        }

        return $this->render('CoreBundle:Admin/Test:edit.html.twig', array(
            'test' => $test,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a test entity.
     *
     * @Route("/{id}", name="admin_test_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Test $test)
    {
        $form = $this->createDeleteForm($test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($test);
            $em->flush();
        }

        return $this->redirectToRoute('admin_test_index');
    }

    /**
     * Creates a form to delete a test entity.
     *
     * @param Test $test The test entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Test $test)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_test_delete', array('id' => $test->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
