<?php

namespace CoreBundle\Repository;

/**
 * TestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TestRepository extends \Doctrine\ORM\EntityRepository
{
  public function getTestswithAssociations() {
    $tests = $this->createQueryBuilder('t')
    ->orderBy("t.id", "DESC")
    ->leftJoin("t.article", "art")
    ->addSelect("art")
    ->leftJoin("t.testBlocs","tblc")
    ->addSelect("tblc")
    ->getQuery()
    ->getResult();

    return $tests;
  }
}
