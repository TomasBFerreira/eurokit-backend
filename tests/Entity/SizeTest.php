<?php

namespace App\Tests\Entity;

use App\Entity\Size;

use PHPUnit\Framework\TestCase;

class SizeTest extends TestCase
{
    public function testID()
    {
    
        $size = new Size();
        
        $this->assertNull($size->getId());
        
    }
    
    public function testSize()
    {
        
        $size = new Size();
        $small = 3;
        
        $size->setSize($small);

        $this->assertSame($small, $size->getSize());
        
    }
    
}
