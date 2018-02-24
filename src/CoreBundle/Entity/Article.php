<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use CoreBundle\Entity\OrderableItem;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ArticleRepository")
 */
class Article extends OrderableItem
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *@ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"remove"})
     */
    private $image;

    /**
     *@ORM\ManyToMany(targetEntity="CoreBundle\Entity\Category", inversedBy="articles", cascade={"persist"})
     */
    private $categories;

    /**
     *@ORM\ManyToOne(targetEntity="CoreBundle\Entity\Module", inversedBy="articles")
     *@ORM\JoinColumn(nullable=true)
    */
    private $module;

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->categories = new ArrayCollection;
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
     * @return Article
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
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set image
     *
     * @param \CoreBundle\Entity\Image $image
     *
     * @return Article
     */
    public function setImage(\CoreBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \CoreBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Add category
     *
     * @param \CoreBundle\Entity\Category $category
     *
     * @return Article
     */
    public function addCategory(\CoreBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        $category->addArticle($this);

        return $this;
    }

    /**
     * Remove category
     *
     * @param \CoreBundle\Entity\Category $category
     */
    public function removeCategory(\CoreBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set module
    */

    public function setModule(Module $module = null) {
      $this->module = $module;
    }

    /**
    * Get Module
    */

    public function getModule() {
      return $this->module;
    }

}
