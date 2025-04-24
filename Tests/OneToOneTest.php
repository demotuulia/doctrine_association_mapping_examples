<?php

namespace Tests;

/**
 *  OneToOne Example and Test
 *
 */
require_once __DIR__ . '/BaseTest.php';

use App\Entity\Cart;
use App\Entity\Customer;
use Doctrine\ORM\EntityRepository;
use Tests\BaseTest;

class OneToOneTest extends BaseTest
{

    public function example()
    {

        //
        // Insert customer
        //
        $customer = new Customer();
        $customer->setName('customer 1');
        $this->doctrineEm->persist($customer);
        $this->doctrineEm->flush();

        //
        // Insert cart
        //
        $cart = new Cart($customer);
        $cart->setNumber('cart1');
        $this->doctrineEm->persist($cart);
        $this->doctrineEm->flush();

        //
        // Get customer from db and print the cart number
        //
        $customerRepository = $this->doctrineEm->getRepository('App\Entity\Customer');
        $customerDb = current($customerRepository->findBy(['name' => 'customer 1']));
        var_dump($customerDb->getCart()->getNumber()); // prints "cart1"

        //
        // Get  cart  from db and print the customer name
        //
        $cartRepository = $this->doctrineEm->getRepository('App\Entity\Cart');
        $cartDb = current($cartRepository->findBy(['number' => 'cart1']));
        var_dump($cartDb->getCustomer()->getName());
    }

    /**
     *  testOneToOne
     */
    public function testOneToOne(): void
    {
        //
        // Insert 
        //
        $customer1  = $this->insertCustomer('customer1');
        $customer2  = $this->insertCustomer('customer2');

        $cart1 = $this->insertCart('cart1', $customer1);
        $cart2 = $this->insertCart('cart2', $customer2);

        //
        // Check customer 1 cart
        //
        /** @var  EntityRepository $customerRepository  */
        $customerRepository = $this->doctrineEm->getRepository('App\Entity\Customer');
        /** @var Customer $customer1 */
        $customer1 = current($customerRepository->findBy(['name' => 'customer1']));

        $this->assertEquals(
            'cart1',
            $customer1->getCart()->getNumber()
        );

        //
        // Check cart 2  customer
        //
        $cartRepository = $this->doctrineEm->getRepository('App\Entity\Cart');
        /** @var Cart $cart2 */
        $cart2 = current($cartRepository->findBy(['number' => 'cart2']));
        $this->assertEquals('customer2', $cart2->getCustomer()->getName());
    }

    /**
     * Insert cart
     */
    private function insertCart(string $number, Customer $customer): Cart
    {
        /** @var Cart $eCart */
        $eCart = new Cart($customer);
        $eCart->setNumber($number);
        $this->doctrineEm->persist($eCart);
        $this->doctrineEm->flush();
        return $eCart;
    }

    /**
     * Insert customer
     */
    private function insertCustomer(string $name): Customer
    {
        $eCustomer = new Customer();
        $eCustomer->setName($name);
        $this->doctrineEm->persist($eCustomer);
        $this->doctrineEm->flush();
        return $eCustomer;
    }
}
