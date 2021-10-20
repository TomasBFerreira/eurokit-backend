<?php

namespace App\Tests\Entity;

use App\Entity\Model;

use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase 
    {
    
    public function testID() 
        {
        
        $model = new Model();
        
        $this->assertNull($model->getId());
        }
    }
