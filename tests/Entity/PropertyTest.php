<?php

namespace App\Tests\Entity;

use App\Entity\Property;

use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    public function testID()
    {

        $property = new Property();

        $this->assertNull($property->getId());
    }
    
    public function testName()
    {

        $property = new Property();
        $name = 'My Property';

        $property->setName($name);

        $this->assertSame($name, $property->getName());
    }
    
    public function testValue() 
    {
        
        $property = new Property();
        $value = 'Value';

        $property->setValue($value);

        $this->assertSame($value, $property->getValue());
    }
}
