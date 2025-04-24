<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity]
#[ORM\Table(name: 'phone_number')]
class PhoneNumber
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $number;

    #[ManyToMany(targetEntity: 'User', mappedBy: 'phoneNumbers')]
    /**@var Collection<int,User> */
    private Collection $users;

    /**
     * construct
     * 
     */
    public function __construct()
    {

        $this->users = new ArrayCollection();
    }
    
    /**
     * getId
     * 
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * setNumber
     * 
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * getNumber
     * 
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * addUser
     * 
     * For internal use, never call directly.
     * 
     * @internal
     */
    public function addUser(User $user): void
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }
    }

    /**
     * @return array<User>
     */
    public function getUsers() : array 
    {
        return $this->users->toArray();
    }
}
