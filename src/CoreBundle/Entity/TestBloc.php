<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TestBloc
 *
 * @ORM\Table(name="test_bloc")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\TestBlocRepository")
 */
class TestBloc
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
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="firstFalse", type="text")
     */
    private $firstFalse;

    /**
     * @var string
     *
     * @ORM\Column(name="secondFalse", type="text")
     */
    private $secondFalse;

    /**
     * @var string
     *
     * @ORM\Column(name="thirdFalse", type="text", nullable=true)
     */
    private $thirdFalse;

    /**
     * @var string
     *
     * @ORM\Column(name="rightAnswer", type="text")
     */
    private $rightAnswer;


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
     * Set question
     *
     * @param string $question
     *
     * @return TestBloc
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set firstFalse
     *
     * @param string $firstFalse
     *
     * @return TestBloc
     */
    public function setFirstFalse($firstFalse)
    {
        $this->firstFalse = $firstFalse;

        return $this;
    }

    /**
     * Get firstFalse
     *
     * @return string
     */
    public function getFirstFalse()
    {
        return $this->firstFalse;
    }

    /**
     * Set secondFalse
     *
     * @param string $secondFalse
     *
     * @return TestBloc
     */
    public function setSecondFalse($secondFalse)
    {
        $this->secondFalse = $secondFalse;

        return $this;
    }

    /**
     * Get secondFalse
     *
     * @return string
     */
    public function getSecondFalse()
    {
        return $this->secondFalse;
    }

    /**
     * Set thirdFalse
     *
     * @param string $thirdFalse
     *
     * @return TestBloc
     */
    public function setThirdFalse($thirdFalse)
    {
        $this->thirdFalse = $thirdFalse;

        return $this;
    }

    /**
     * Get thirdFalse
     *
     * @return string
     */
    public function getThirdFalse()
    {
        return $this->thirdFalse;
    }

    /**
     * Set rightAnswer
     *
     * @param string $rightAnswer
     *
     * @return TestBloc
     */
    public function setRightAnswer($rightAnswer)
    {
        $this->rightAnswer = $rightAnswer;

        return $this;
    }

    /**
     * Get rightAnswer
     *
     * @return string
     */
    public function getRightAnswer()
    {
        return $this->rightAnswer;
    }
}

