<?php

namespace Tests;

/**
 *  ManyToMany example and test
 *
 */

require_once __DIR__ . '/BaseTest.php';

use App\Entity\PhoneNumber;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Tests\BaseTest;

class ManyToManyTest extends BaseTest
{

    public function example()
    {

        //
        // Insert Phone numbers
        //
        $phoneNumber1 = new PhoneNumber();
        $phoneNumber1->setNumber('11111');
        $this->doctrineEm->persist($phoneNumber1);
        $this->doctrineEm->flush();

        $phoneNumber2 = new PhoneNumber();
        $phoneNumber2->setNumber('22222');
        $this->doctrineEm->persist($phoneNumber2);
        $this->doctrineEm->flush();

        $phoneNumber3 = new PhoneNumber();
        $phoneNumber3->setNumber('33333');
        $this->doctrineEm->persist($phoneNumber3);
        $this->doctrineEm->flush();

        //
        // Insert users with phone numbers
        //
        $user1 = new User([$phoneNumber1, $phoneNumber2]);
        $user1->setName('user1');
        $this->doctrineEm->persist($user1);
        $this->doctrineEm->flush();

        $user2 = new User([$phoneNumber2]);
        $user2->setName('user2');
        $this->doctrineEm->persist($user2);
        $this->doctrineEm->flush();

        //
        // Get the  user 1 from yhe database and print the phone numbers
        //
        $userRepository = $this->doctrineEm->getRepository('App\Entity\User');
        $userDb = current($userRepository->findBy(['name' => 'user1']));

        $phoneNumbers = $userDb->getPhoneNumbers();
        foreach ($phoneNumbers as $phoneNumber) {
            var_dump($phoneNumber->getNumber()); // prints "11111", "22222"
        }

        //
        // Add phone number 3 to user 1
        //
        $userDb->addPhoneNumber($phoneNumber3);
        $this->doctrineEm->persist($userDb);
        $this->doctrineEm->flush();

        //
        // Get user 1 again from the database
        //
        unset($userDb );
        $userDb = current($userRepository->findBy(['name' => 'user1']));
        $phoneNumbers = $userDb->getPhoneNumbers();
        foreach ($phoneNumbers as $phoneNumber) {
            var_dump($phoneNumber->getNumber()); // prints "11111", "22222", "33333"
        }
      
        //
        // Get phone number '22222' and print its users
        //
        $phoneNumberRepository = $this->doctrineEm->getRepository('App\Entity\PhoneNumber');
        $phoneNumber = current($phoneNumberRepository->findBy(['number' => '22222']));
        $phoneNumberUsers = $phoneNumber->getUsers();
        foreach ($phoneNumberUsers as $phoneNumberUser) {
            var_dump($phoneNumberUser->getName()); // prints  "user1",  "user2"
        }
    }

    /**
     *  test ManyToMany
     */
    public function testManyToMany(): void
    {
        //
        // Insert 
        //
        $phoneNumber1  = $this->insertPhoneNumber('11111');
        $phoneNumber2  = $this->insertPhoneNumber('22222');
        $phoneNumber3  = $this->insertPhoneNumber('33333');

        $this->insertUser('user1', [$phoneNumber1, $phoneNumber3]);
        $this->insertUser('user2', [$phoneNumber2, $phoneNumber3]);

        //
        // Check user 1 phone numbers
        //  
        /** @var  EntityRepository $userRepository   */
        $userRepository = $this->doctrineEm->getRepository('App\Entity\User');
        /** @var User $user1 */
        $user1 = current($userRepository->findBy(['name' => 'user1']));
        $numbers = array_map(
            function (PhoneNumber $number) {
                return $number->getNumber();
            },
            $user1->getPhoneNumbers()
        );

        $expected = [
            '11111',
            '33333',
        ];

        $this->assertEquals($expected, $numbers);

        //
        // Check phone number 3 users
        //
        /** @var  EntityRepository $phoneNumberRepository  */
        $phoneNumberRepository = $this->doctrineEm->getRepository('App\Entity\PhoneNumber');
        /** @var PhoneNumber $phoneNumber3 */
        $phoneNumber3 = current($phoneNumberRepository->findBy(['number' => '33333']));
        $users = array_map(
            function (User $user) {
                return $user->getName();
            },
            $phoneNumber3->getUsers()
        );

        $expected = [
            'user1',
            'user2',
        ];

        $this->assertEquals($expected, $users);
    }

    /**
     * Insert phone number
     */
    private function insertPhoneNumber(string $number): PhoneNumber
    {
        /** @var PhoneNumber $ePhoneNumber */
        $ePhoneNumber = new PhoneNumber();
        $ePhoneNumber->setNumber($number);
        $this->doctrineEm->persist($ePhoneNumber);
        $this->doctrineEm->flush();
        return $ePhoneNumber;
    }

    /**
     * Insert user
     * 
     * @param array<string> $phoneNumbers
     */
    private function insertUser(string $name, array $phoneNumbers): User
    {
        $eUser = new User($phoneNumbers);
        $eUser->setName($name);
        $this->doctrineEm->persist($eUser);
        $this->doctrineEm->flush();
        return $eUser;
    }
}
