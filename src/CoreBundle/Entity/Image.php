<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="bigint")
     */
    private $weight;

    private $file;


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
     * Set name
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return Image
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }



    /**
     * Get weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Get fullPath
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->path . $this->name;
    }

    public function setFile( $file = null)
    {
      $this->file = $file;
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */

    public function getFile()
    {
      return $this->file;
    }

    public function upload() {
      if($this->file === null) {
        return;
      }

      //get the name of the uploaded file
      $name = $this->file->getClientOriginalName();
      $this->setName($name);

      $weight = $this->file->getClientSize();
      $this->setWeight($weight);

      $this->setPath("img/");

      $this->file->move($this->getUploadRootDir(), $name);

    }

    protected function getUploadRootDir()
    {
      return __DIR__.'/../../../web/img';
    }
}
