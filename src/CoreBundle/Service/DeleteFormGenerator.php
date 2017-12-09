<?php

namespace CoreBundle\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class DeleteFormGenerator {

  private $formFactory;
  private $router;

  public function __construct(FormFactoryInterface $formFactory, Router $router)
  {
    $this->formFactory = $formFactory;
    $this->router = $router;
  }

  //Loop through an array of entities en generate the corresponding delete one for each one
  public function generateDeleteForms($entities, $path) {
    $deleteForm = [];
    foreach ($entities as $key => $entity) {
      $deleteForm[$key] = $this->createDeleteForm($entity, $path);
      $deleteForm[$key] = $deleteForm[$key]->createView();
    }

    return $deleteForm;
  }

  //Function to create the delete form thanks to the router and formfactory components
  private function createDeleteForm($entity, $path)
  {
      return $this->formFactory->createBuilder()
          ->setAction($this->router->generate($path, array('id' => $entity->getId())))
          ->setMethod('DELETE')
          ->getForm()
      ;
  }

}


 ?>
