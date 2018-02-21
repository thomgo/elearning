<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderableItem
 * @ORM\MappedSuperclass
 */
class OrderableItem
{
  /**
   * @var int
   *
   * @ORM\Column(name="dispatch", type="integer", nullable=true)
   */
  private $dispatch;

  /**
   * Set dispatch
   *
   * @param integer $dispatch
   *
   * @return Path
   */
  public function setDispatch($dispatch)
  {
      $this->dispatch = $dispatch;

      return $this;
  }

  /**
   * Get duration
   *
   * @return int
   */
  public function getDispatch()
  {
      return $this->dispatch;
  }
}
