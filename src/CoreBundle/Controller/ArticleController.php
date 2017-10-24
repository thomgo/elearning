<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('CoreBundle:Article:index.html.twig');
    }

    /**
    * @Route("/article/{id}.{format}", requirements={"id" : "\d+"})
    */
    public function SingleAction($id = 1, $format = "html")
    {
        return $this->render('CoreBundle:Article:single.html.twig', ["id"=>$id]);
    }
}
