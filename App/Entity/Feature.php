<?php

namespace App\Entity;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'feature')]
class Feature
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    /** Many features have one product. This is the owning side. */
    #[ManyToOne(targetEntity: Product::class, inversedBy: 'features')]
    #[JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product|null $product = null;

    /**
     * Constructor
     *
     */
    public function __construct(Product $product)
    {
        $product->addFeature($this);
        $this->product = $product;
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
     * Add product
     * 
     * For internal use, never call directly.
     * 
     * @internal 
     */
    public function addProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * Get product
     * 
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
}
