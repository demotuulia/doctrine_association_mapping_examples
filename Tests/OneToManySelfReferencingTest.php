<?php

namespace Tests;

/**
 *  OneToMany, Self-referencing Example and Test
 *
 */

require_once __DIR__ . '/BaseTest.php';

use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Tests\BaseTest;

class OneToManySelfReferencingTest extends BaseTest
{
    public function example(): void
    {
        //
        //  Insert Parent category
        //
        $parentCategory = new Category();
        $parentCategory->setName('parent');
        $this->doctrineEm->persist($parentCategory);
        $this->doctrineEm->flush();

        //
        //  Insert child categories
        //
        $child1Category1 = new Category($parentCategory);
        $child1Category1->setName('child 1');
        $this->doctrineEm->persist($child1Category1);
        $this->doctrineEm->flush();

        $child1Category2 = new Category($parentCategory);
        $child1Category2->setName('child 2');
        $this->doctrineEm->persist($child1Category2);
        $this->doctrineEm->flush();

        //
        // Print child categories of the parent category
        //
        $categoryRepository = $this->doctrineEm->getRepository('App\Entity\Category');

        $parentDb = current($categoryRepository->findBy(['name' => 'parent']));
        foreach ($parentDb->getChildren() as $child) {
            var_dump($child->getName()); // prints  "child 1" ,  "child 2"
        }

        //
        // Print parent of child 1 category 
        //
        $childDb = current($categoryRepository->findBy(['name' => 'child 2']));
        var_dump($childDb->getParent()->getName()); // prints parent
    }

    /**
     *  testOneToMany
     */
    public function testOneToMany(): void
    {
        //
        // Insert 
        //
        $parentA = $this->insertCategory('parent A');
        $parentB = $this->insertCategory('parent B');
        $childB1 = $this->insertCategory('child B1', $parentB);
        $this->insertCategory('child A1', $parentA);
        $this->insertCategory('child A2', $parentA);
        $this->insertCategory('child A3', $parentA);
        $this->insertCategory('child B2', $parentB);
        $this->insertCategory('child B3', $parentB);

        //
        // Test the category parentA children
        //
        /** @var  EntityRepository $categoryRepository  */
        $categoryRepository = $this->doctrineEm->getRepository('App\Entity\Category');

        /** @var Category $parentA */
        $parentA = current($categoryRepository->findBy(['name' => 'parent A']));
        $actualParentAChildren = array_map(
            function (Category $child) {
                return $child->getName();
            },
            $parentA->getChildren()
        );

        $expected = [
            0 => 'child A1',
            1 => 'child A2',
            2 => 'child A3',
        ];
        $this->assertEquals($expected, $actualParentAChildren);

        //
        // Test the category childB1 parent
        //
        /** @var Category  $childB1 */
        $childB1 = current($categoryRepository->findBy(['name' => 'child B1']));
        /** @var Category  $parent */
        $parent = $childB1->getParent();
        $this->assertEquals('parent B', $parent->getName());
    }

    /**
     * Insert Category
     */
    private function insertCategory(string $name, ?Category $parent = null): Category
    {
        /** @var Category $eCategory */
        $eCategory = new Category($parent);
        $eCategory->setName($name);
        $this->doctrineEm->persist($eCategory);
        $this->doctrineEm->flush();
        return $eCategory;
    }
}
