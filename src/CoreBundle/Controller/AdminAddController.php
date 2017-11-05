<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Category;
use CoreBundle\Form\CategoryType;

class AdminAddController extends Controller
{

  /**
   * @Route("/admin/add/Category", name ="adminAddCategory")
   */
  public function addCategoryAction(Request $request)
  {
    $category  = new Category();
    $form = $this->get('form.factory')->create(CategoryType::class, $category);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Categorie enregistrée.');

      return $this->redirectToRoute('adminView', array('entity' => "Category"));
    }

    return $this->render('CoreBundle:Admin:adminAdd.html.twig', ["form"=>$form->createView()]);
  }
}
