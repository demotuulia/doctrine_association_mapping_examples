<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name: 'category')]
class Category
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'integer',  name: "parent_id")]
    private ?int $parentId;

    /**
     * One Category has Many Categories.
     * @var Collection<int, Category>
     */
    #[OneToMany(targetEntity: Category::class, mappedBy: 'parent')]
    private Collection $children;

    /** Many Categories have One Category. */
    #[ManyToOne(targetEntity: Category::class, inversedBy: 'children')]
    #[JoinColumn(name: 'parent_id', referencedColumnName: 'id')]
    private Category|null $parent = null;

    /**
     * construct
     * 
     */
    public function __construct(?Category $parent = null)
    {
        $this->children = new ArrayCollection();
        if ($parent !== null) {
            $parent->addChild($this);
            $this->parentId = $parent->getId();
            $this->parent = $parent;
        }
    }

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
     * getParent
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }


    /**
     * @return array<int, Category>
     */
    public function getChildren(): array
    {
        return $this->children->toArray();
    }

    /**
     * addChild
     * 
     * For internal use, never call directly.
     * 
     * @internal
     */
    public function addChild(self $child): void
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }
    }
}
