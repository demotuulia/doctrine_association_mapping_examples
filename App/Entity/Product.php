<?php

namespace App\Entity;

use App\Entity\Feature;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name: 'product')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * One product has many features. This is the inverse side.
     * @var Collection<int, Feature>
     */
    #[OneToMany(targetEntity: Feature::class, mappedBy: 'product')]
    private Collection $features;

    /**
     * construct
     * 
     */
    public function __construct()
    {
        $this->features = new ArrayCollection();
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
     * Add feature
     * 
     * For internal use, never call directly.
     * 
     * @internal 
     */
    public function addFeature(Feature $feature): void
    {
        $this->features->add($feature);
    }

    /**
     * Get features
     * 
     * @return array<Feature>
     */
    public function getFeatures(): array
    {
        return $this->features->toArray();
    }
}
