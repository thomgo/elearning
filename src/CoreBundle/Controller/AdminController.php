<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

  /**
   * @Route("/admin/index", name ="adminIndex")
   */
  public function indexAction()
  {
    return $this->render('CoreBundle:Admin:adminIndex.html.twig');
  }

  /**
   * @Route("/admin/view/{entity}", requirements={"entity" : "[a-z A-Z]+"}, name ="adminView")
   */
  public function viewAction($entity)
  {
    $em  = $this->getDoctrine()->getManager();
    $entityRepository = $em->getRepository('CoreBundle:' . $entity);

    $entities = $entityRepository->findAll();

    return $this->render('CoreBundle:Admin/Views:' . $entity . 'View.html.twig', ["entities"=>$entities]);
  }
}
