<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use App\Entity\Series;

use PHPUnit\Framework\TestCase;

class SeriesTest extends TestCase
{
    public function testID()
    {

        $series = new Series();

        $this->assertNull($series->getId());
    }

    public function testName()
    {

        $series = new Series();
        $name = 'My Seires';

        $series->setName($name);

        $this->assertSame($name, $series->getName());
    }
    
    public function testProducts()
    {

        $series = new Series();


        $this->assertCount(0, $series->getProducts());

        $product = new Product();
        $product2 = new Product();

        $series->addProduct($product);
        $this->assertCount(1, $series->getProducts());

        $series->addProduct($product2);
        $this->assertCount(2, $series->getProducts());

        $series->removeProduct($product);
        $this->assertCount(1, $series->getProducts());
    }
    
}
