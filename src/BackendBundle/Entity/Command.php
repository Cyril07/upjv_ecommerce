<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table(name="command")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\CommandRepository")
 */
class Command
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_command", type="datetime")
     */
    private $dateCommand;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     */
    private $customer;


    public function __toString() {
        return $this->customer;
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
     * Set dateCommand
     *
     * @param \DateTime $dateCommand
     *
     * @return Command
     */
    public function setDateCommand($dateCommand)
    {
        $this->dateCommand = $dateCommand;

        return $this;
    }

    /**
     * Get dateCommand
     *
     * @return \DateTime
     */
    public function getDateCommand()
    {
        return $this->dateCommand;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Command
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set customer
     *
     * @param \BackendBundle\Entity\Customer $customer
     *
     * @return Command
     */
    public function setCustomer(\BackendBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \BackendBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
