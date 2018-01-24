<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Service\DeleteFormGenerator;

/**
 * Module controller.
 *
 * @Route("admin/module")
 */
class ModuleController extends Controller
{
    /**
     * Lists all module entities.
     *
     * @Route("/", name="admin_module_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(DeleteFormGenerator $DeleteFormGenerator , Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $choices = ["test1", "test2", "test3", "test4"];
        $sortingForm = $this->createForm('CoreBundle\Form\SortingType',null, ['choices'=>$choices]);

        $sortingForm->handleRequest($request);

         if ($sortingForm->isSubmitted() && $sortingForm->isValid()) {
             // data is an array with "name", "email", and "message" keys
             $sortingKey = $sortingForm->getData();
         }

        $modules = $em->getRepository('CoreBundle:Module')->findAll();

        $deleteForm = $DeleteFormGenerator->generateDeleteForms($modules, 'admin_module_delete');

        return $this->render('CoreBundle:Admin/Module:index.html.twig', array(
            'modules' => $modules,
            'delete_form'=>$deleteForm,
            'sorting_form' => $sortingForm->createView()
        ));
    }

    /**
     * Creates a new module entity.
     *
     * @Route("/new", name="admin_module_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $module = new Module();
        $form = $this->createForm('CoreBundle\Form\ModuleType', $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('admin_module_show', array('id' => $module->getId()));
        }

        return $this->render('CoreBundle:Admin/Module:new.html.twig', array(
            'module' => $module,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a module entity.
     *
     * @Route("/{id}", name="admin_module_show")
     * @Method("GET")
     */
    public function showAction(Module $module)
    {
        $deleteForm = $this->createDeleteForm($module);

        return $this->render('CoreBundle:Admin/Module:show.html.twig', array(
            'module' => $module,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing module entity.
     *
     * @Route("/{id}/edit", name="admin_module_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Module $module)
    {
        $deleteForm = $this->createDeleteForm($module);
        $editForm = $this->createForm('CoreBundle\Form\ModuleType', $module);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_module_edit', array('id' => $module->getId()));
        }

        return $this->render('CoreBundle:Admin/Module:edit.html.twig', array(
            'module' => $module,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a module entity.
     *
     * @Route("/{id}", name="admin_module_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Module $module)
    {
        $form = $this->createDeleteForm($module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($module);
            $em->flush();
        }

        return $this->redirectToRoute('admin_module_index');
    }

    /**
     * Creates a form to delete a module entity.
     *
     * @param Module $module The module entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Module $module)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_module_delete', array('id' => $module->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
