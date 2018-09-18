<?php

namespace CoreBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class OrderEntities
{

    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function order($entityRepository, $orderAttribut)
    {
      $request = $this->requestStack->getCurrentRequest();
      $newOrder = $request->request->get('order');

      $entitiesToOrder = $entityRepository->findBy(["title"=>$newOrder]);

      foreach ($entitiesToOrder as $entity) {
        $method = "get" . ucfirst($orderAttribut);
        $entity->setDispatch(array_search($entity->$method(), $newOrder));
      }
      return $entitiesToOrder;
    }
}

 ?>
