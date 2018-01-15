<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Basket
 *
 * @ORM\Table(name="basket")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\BasketRepository")
 */
class Basket
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="Command")
     */
    private $command;


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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Basket
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set article
     *
     * @param \BackendBundle\Entity\Article $article
     *
     * @return Basket
     */
    public function setArticle(\BackendBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \BackendBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set command
     *
     * @param \BackendBundle\Entity\Command $command
     *
     * @return Basket
     */
    public function setCommand(\BackendBundle\Entity\Command $command = null)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return \BackendBundle\Entity\Command
     */
    public function getCommand()
    {
        return $this->command;
    }
}
