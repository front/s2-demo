<?php

namespace Fk\StrategyMakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Fk\StrategyMakerBundle\Entity\Goal
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Goal
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
     * @ORM\ManyToOne(targetEntity="Strategy", inversedBy="goals")
     * @ORM\JoinColumn(name="strategy_id", referencedColumnName="id")
     */
    protected $strategy;

    /**
     * @ORM\OneToMany(targetEntity="Action", mappedBy="goal")
     */
    protected $actions;
    
    public function __toString()
    {
        return $this->title;
    }
    
    public function __construct()
    {
        $this->actions = new ArrayCollection();
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
     * @return Goal
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
     * Set strategy
     *
     * @param Fk\StrategyMakerBundle\Entity\Strategy $strategy
     * @return Goal
     */
    public function setStrategy(\Fk\StrategyMakerBundle\Entity\Strategy $strategy = null)
    {
        $this->strategy = $strategy;
    
        return $this;
    }

    /**
     * Get strategy
     *
     * @return Fk\StrategyMakerBundle\Entity\Strategy 
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * Add actions
     *
     * @param Fk\StrategyMakerBundle\Entity\Action $actions
     * @return Goal
     */
    public function addAction(\Fk\StrategyMakerBundle\Entity\Action $actions)
    {
        $this->actions[] = $actions;
    
        return $this;
    }

    /**
     * Remove actions
     *
     * @param Fk\StrategyMakerBundle\Entity\Action $actions
     */
    public function removeAction(\Fk\StrategyMakerBundle\Entity\Action $actions)
    {
        $this->actions->removeElement($actions);
    }

    /**
     * Get actions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActions()
    {
        return $this->actions;
    }
}