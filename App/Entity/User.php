<?php

namespace App\Entity;

use App\Entity\PhoneNumber;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[JoinTable(name: 'user_phone_number')]
    #[JoinColumn(name: 'phonenumber_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'user_id', referencedColumnName: 'id', unique: true)]
    #[ManyToMany(targetEntity: 'PhoneNumber', inversedBy: 'users')]
    /** @var Collection<int, PhoneNumber>*/
    private Collection $phoneNumbers;

    /**
     * construct    
     * 
     * @param array<PhoneNumber> $numbers
     */
    public function __construct(array $numbers = [])
    {
        if (!empty($numbers)) {
            foreach($numbers as $number) {
                $number->addUser($this);
            }
        }
        $this->phoneNumbers = new ArrayCollection($numbers);
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
     * setName
     * 
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * getName
     * 
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get phone numbers
     * 
     * @return array<PhoneNumber>
     */
    public function getPhoneNumbers() : array
    {
        return $this->phoneNumbers->toArray();
    }
}
