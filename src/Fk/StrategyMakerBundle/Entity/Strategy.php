<?php

namespace Fk\StrategyMakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fk\StrategyMakerBundle\Entity\Strategy
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Strategy
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
     * @var string $vision
     *
     * @ORM\Column(name="vision", type="string", length=255)
     */
    private $vision;

    /**
     * @ORM\OneToMany(targetEntity="Goal", mappedBy="strategy")
     */
    protected $goals;
    
    public function __construct()
    {
        $this->goals = new ArrayCollection();
    }
    
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
     * @return Strategy
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
     * Set vision
     *
     * @param string $vision
     * @return Strategy
     */
    public function setVision($vision)
    {
        $this->vision = $vision;
    
        return $this;
    }

    /**
     * Get vision
     *
     * @return string 
     */
    public function getVision()
    {
        return $this->vision;
    }

    /**
     * Add goals
     *
     * @param Fk\StrategyMakerBundle\Entity\Goal $goals
     * @return Strategy
     */
    public function addGoal(\Fk\StrategyMakerBundle\Entity\Goal $goals)
    {
        $this->goals[] = $goals;
    
        return $this;
    }

    /**
     * Remove goals
     *
     * @param Fk\StrategyMakerBundle\Entity\Goal $goals
     */
    public function removeGoal(\Fk\StrategyMakerBundle\Entity\Goal $goals)
    {
        $this->goals->removeElement($goals);
    }

    /**
     * Get goals
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGoals()
    {
        return $this->goals;
    }
}