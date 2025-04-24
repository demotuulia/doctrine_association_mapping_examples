<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customer;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity]
#[ORM\Table(name: 'cart')]
class Cart
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $number;

    /** One Cart has One Customer. */
    #[OneToOne(targetEntity: Customer::class, inversedBy: 'cart')]
    private Customer $customer;

    /**
     * construct
     * 
     */
    public function __construct(Customer $customer)
    {
        $customer->addCart($this);
        $this->customer = $customer;
    }

    /**
     * getId
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * setNumber
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * getNumber
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * addCustomer
     * 
     * For internal use, never call directly.
     * 
     * @internal
     */
    public function addCustomer(Customer $customer): void
    {
        $this->customer = $customer;   
    }

    /**
     * Get customer
     */
    public function getCustomer() : Customer
    {
        return $this->customer;
    }
}
