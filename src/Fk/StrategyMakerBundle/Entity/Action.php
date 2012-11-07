<?php

namespace Fk\StrategyMakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fk\StrategyMakerBundle\Entity\Action
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Action
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string $challenge
     *
     * @ORM\Column(name="challenge", type="text")
     */
    private $challenge;

    /**
     * @var \DateTime $start_date
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $start_date;

    /**
     * @ORM\ManyToOne(targetEntity="Goal", inversedBy="actions")
     * @ORM\JoinColumn(name="goal_id", referencedColumnName="id")
     */
    protected $goal;
        
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Action
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
     * Set challenge
     *
     * @param string $challenge
     * @return Action
     */
    public function setChallenge($challenge)
    {
        $this->challenge = $challenge;
    
        return $this;
    }

    /**
     * Get challenge
     *
     * @return string 
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return Action
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    
        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set goal
     *
     * @param Fk\StrategyMakerBundle\Entity\Goal $goal
     * @return Action
     */
    public function setGoal(\Fk\StrategyMakerBundle\Entity\Goal $goal = null)
    {
        $this->goal = $goal;
    
        return $this;
    }

    /**
     * Get goal
     *
     * @return Fk\StrategyMakerBundle\Entity\Goal 
     */
    public function getGoal()
    {
        return $this->goal;
    }
}