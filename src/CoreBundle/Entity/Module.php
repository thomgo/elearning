<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use CoreBundle\Entity\OrderableItem;

/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ModuleRepository")
 */
class Module extends OrderableItem
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
     * @var int
     *
     * @ORM\Column(name="difficulty", type="integer")
     */
    private $difficulty;

    /**
     *@ORM\ManyToOne(targetEntity="CoreBundle\Entity\Path", inversedBy="modules")
     *@ORM\JoinColumn(nullable=true)
    */
    private $path;

    /**
    *@ORM\OneToMany(targetEntity="CoreBundle\Entity\Article", mappedBy="module")
    */
    private $articles;

    public function __construct() {
      $this->articles = new ArrayCollection;
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
     * @return Module
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
     * @return Module
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
     * Set difficulty
     *
     * @param integer $difficulty
     *
     * @return Module
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return int
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set path
    */

    public function setPath(Path $path = null) {
      $this->path = $path;
    }

    /**
    * Get Path
    */

    public function getPath() {
      return $this->path;
    }

    /**
    * @return Collection|Articles[]
    */
    public function getArticles() {
      return $this->articles;
    }

    public function addArticle(Article $article) {
      if($this->articles->contains($article)) {
        return;
      }

      $this->articles[] = $article;

      $article->setModule($this);
    }

    public function removeArticle(Article $article) {
      $this->articles->removeElement($article);
      $article->setModule(null);
    }
}
