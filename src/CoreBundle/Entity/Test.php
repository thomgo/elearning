<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\TestRepository")
 */
class Test
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     *
     *@ORM\OneToMany(targetEntity="CoreBundle\Entity\TestBloc", mappedBy="test", cascade={"persist", "remove"})
     */
    private $testBlocs;

    public function __construct() {
      $this->testBlocs = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add testBloc
     */
    public function addTestBloc(TestBloc $testBloc = null)
    {
        if($this->testBlocs->contains($TestBloc)) {
          return;
        }

        $this->testBlocs[] = $testBloc;
        $testBloc->setTest($this);
    }

    /**
     * Remove testBloc
     */
    public function RemoveTestBloc(TestBloc $testBloc)
    {
        $this->testBlocs->removeElement($testBloc);
        $testBloc->setTest(null);
    }

    /**
     * Get testBloc
     */
    public function getTestBlocs()
    {
        return $this->testBlocs;
    }
}
