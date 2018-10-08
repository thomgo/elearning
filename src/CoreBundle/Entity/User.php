<?php
// src/CoreBundle/Entity/User.php

namespace CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", nullable = true)
     */
    private $bio;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
    * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\Path", inversedBy="users", cascade={"persist"})
    **/
    private $paths;

    public function __construct()
    {
        parent::__construct();
        $this->paths = new ArrayCollection();
    }

    /**
     * Set bio
     *
     * @param string $bio
     *
     * @return Article
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Module
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Add Path
     *
     * @param \CoreBundle\Entity\Path $path
     *
     * @return User
     */
    public function addPath(\CoreBundle\Entity\Path $path)
    {
      if ($this->paths->contains($path)) {
          return;
        }
        $this->paths[] = $path;

        $path->addUser($this);

        return $this;
    }

    /**
     * Remove path
     *
     * @param \CoreBundle\Entity\Path $path
     */
    public function removePath(\CoreBundle\Entity\Path $path)
    {
        $this->paths->removeElement($path);
    }

    /**
     * Get paths
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaths()
    {
        return $this->paths;
    }
}
