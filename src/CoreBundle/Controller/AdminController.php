<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

  /**
   * @Route("/admin", name ="admin")
   */
  public function indexAction()
  {
    return $this->render('CoreBundle:Admin:adminIndex.html.twig');
  }
}
