<?php

namespace App\Tests\Entity;

use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Property;
use App\Entity\Size;

use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{

    public function testID()
    {

        $model = new Model();

        $this->assertNull($model->getId());
    }

    public function testCode()
    {

        $model = new Model();
        $code = 'Model Code';

        $model->setCode($code);
        $this->assertEquals('Model Code', $model->getCode());
    }
    
    public function testDescription()
    {

        $model = new Model();
        $description = 'Model Description';

        $model->setDescription($description);
        $this->assertEquals('Model Description', $model->getDescription());
    }
    
    public function testProduct()
    {

        $model = new Model();
        $product = new Product();

        $model->setProduct($product);

        $this->assertSame($product, $model->getProduct());
    }
    
    public function testProperties()
    {
        
        $model = new Model();


        $this->assertCount(0, $model->getProperties());

        $property = new Property();
        $property2 = new Property();

        $model->addProperty($property);
        $this->assertCount(1, $model->getProperties());

        $model->addProperty($property2);
        $this->assertCount(2, $model->getProperties());

        $model->removeProperty($property);
        $this->assertCount(1, $model->getProperties());

    }
    
    public function testSize()
    {
        
        $model = new Model();


        $this->assertCount(0, $model->getSizes());

        $size = new Size();
        $size2 = new Size();

        $model->addSize($size);
        $this->assertCount(1, $model->getSizes());

        $model->addSize($size2);
        $this->assertCount(2, $model->getSizes());

        $model->removeSize($size);
        $this->assertCount(1, $model->getSizes());

    }
    
    
    
}
