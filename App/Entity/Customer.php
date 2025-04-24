<?php

namespace App\Entity;

use App\Entity\Cart;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity]
#[ORM\Table(name: 'customer')]
class Customer
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

     /** One Customer has One Cart. */
     #[OneToOne(targetEntity: Cart::class, mappedBy: 'customer')]
     private Cart|null $cart = null;

    /**
     * getId
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * setName
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * getName
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Add cart
     * 
     * For internal use, never call directly.
     * 
     * @internal 
     */
    public function addCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    /**
     * Get cart
     * 
     */
    public function getCart() : Cart
    {
        return $this->cart;
    }
}
