<?php

namespace Tests;

/**
 *  ManyToMany Example and Test
 *
 */

require_once __DIR__ . '/BaseTest.php';

use App\Entity\Feature;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Tests\BaseTest;

class OneToManyTest extends BaseTest
{

    public function example(): void
    {
        //
        // Insert a product
        //
        $product = new Product();
        $product->setName('product1');
        $this->doctrineEm->persist($product);
        $this->doctrineEm->flush();

        //
        // Insert two features for the product
        //
        $feature1 = new Feature($product);
        $feature1->setName('feature 1');
        $this->doctrineEm->persist($feature1);
        $this->doctrineEm->flush();

        $feature2 = new Feature($product);
        $feature2->setName('feature 2');
        $this->doctrineEm->persist($feature2);
        $this->doctrineEm->flush();

        //
        // print product features
        //
        $productRepository = $this->doctrineEm->getRepository('App\Entity\Product');
        $productDb = current($productRepository->findBy(['name' => 'product1']));
        foreach ($productDb->getFeatures() as $feature) {
            var_dump($feature->getName()); // prints "feature 1", "feature 2"
        }

        //
        // print feature 2  product name
        //
        $featureRepository = $this->doctrineEm->getRepository('App\Entity\Feature');
        $feature2 = current($featureRepository->findBy(['name' => 'feature 2']));
        var_dump($feature2->getProduct()->getName()); // prints "product1"
    }

    /**
     *  testOneToMany
     */
    public function testOneToMany(): void
    {
        //
        // Insert 
        //
        $product1 = $this->insertProduct('product1');
        $product2 = $this->insertProduct('product2');

        $this->insertFeature('product 1 feature1', $product1);
        $this->insertFeature('product 2 feature2', $product2);
        $this->insertFeature('product 1 feature3', $product1);
        $this->insertFeature('product 2 feature4', $product2);

        //
        // Check product 1 feature
        //
        /** @var  EntityRepository $productRepository  */
        $productRepository = $this->doctrineEm->getRepository('App\Entity\Product');
        /** @var Product $product1 */
        $product1 = current($productRepository->findBy(['name' => 'product1']));

        $features = array_map(
            function (Feature $feature) {
                return $feature->getName();
            },
            $product1->getFeatures()
        );

        $expected = [
            'product 1 feature1',
            'product 1 feature3'
        ];
        $this->assertEquals(
            $expected,
            $features
        );

        //
        // Check feature 2  product
        //
        /** @var  EntityRepository $featureRepository  */
        $featureRepository = $this->doctrineEm->getRepository('App\Entity\Feature');
        /** @var Feature $feature2 */
        $feature2 = current($featureRepository->findBy(['name' => 'product 2 feature4']));
        $this->assertEquals('product2', $feature2->getProduct()->getName());
    }

    /**
     * Insert feature
     */
    private function insertFeature(string $name, Product $product): Feature
    {
        /** @var Feature $eFeature */
        $eFeature = new Feature($product);
        $eFeature->setName($name);
        $this->doctrineEm->persist($eFeature);
        $this->doctrineEm->flush();
        return $eFeature;
    }

    /**
     * Insert product
     */
    private function insertProduct(string $name): Product
    {
        $eProduct = new Product();
        $eProduct->setName($name);
        $this->doctrineEm->persist($eProduct);
        $this->doctrineEm->flush();
        return $eProduct;
    }
}
