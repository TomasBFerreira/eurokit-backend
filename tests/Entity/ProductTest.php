<?php

namespace App\Tests\Entity;

use App\Entity\Image;
use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Series;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testName()
    {

        $product = new Product();
        $name = 'My Product';

        $product->setName($name);

        $this->assertSame($name, $product->getName());
    }

    public function testSeries()
    {

        $product = new Product();
        $series = new Series();

        $product->setSeries($series);

        $this->assertSame($series, $product->getSeries());
    }

    public function testID()
    {

        $product = new Product();

        $this->assertNull($product->getId());
    }

    public function testImages()
    {

        $product = new Product();


        $this->assertCount(0, $product->getImages());

        $image = new Image();
        $image2 = new Image();

        $product->addImage($image);
        $this->assertCount(1, $product->getImages());

        $product->addImage($image2);
        $this->assertCount(2, $product->getImages());

        $product->removeImage($image);
        $this->assertCount(1, $product->getImages());
    }

    public function testModels()
    {

        $product = new Product();


        $this->assertCount(0, $product->getModels());

        $model = new Model();
        $model2 = new Model();

        $product->addModel($model);
        $this->assertCount(1, $product->getModels());

        $product->addModel($model2);
        $this->assertCount(2, $product->getModels());

        $product->removeModel($model);
        $this->assertCount(1, $product->getModels());
    }
}
