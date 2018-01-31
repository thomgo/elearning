<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Path
 *
 * @ORM\Table(name="path")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\PathRepository")
 */
class Path
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
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
    *@ORM\OneToMany(targetEntity="CoreBundle\Entity\Module", mappedBy="path")
    */
    private $modules;

    private $modulesCount;


    public function __construct() {
      $this->modules = new ArrayCollection;
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
     * @return Path
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
     * Set duration
     *
     * @param integer $duration
     *
     * @return Path
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Path
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
    * @return Collection|Modules[]
    */
    public function getModules() {
      return $this->modules;
    }

    public function addModule(Module $module) {
      if($this->modules>contains($module)) {
        return;
      }

      $this->modules[] = $module;

      $module->setPath($this);
    }

    public function removeModule(Module $module) {
      $this->modules->removeElement($module);
      $module->setPath(null);
    }


    public function setModulesCount($count) {
      $this->modulesCount = $count;
    }

    public function getModulesCount() {
      return $this->modulesCount;
    }
}
