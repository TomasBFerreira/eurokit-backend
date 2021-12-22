<?php

namespace App\Tests\Entity;

use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testID()
    {

        $image = new Image();

        $this->assertNull($image->getId());
    }

    public function testFilename()
    {

        $image = new Image();
        $filename = 'abc';

        $image->setFilename($filename);

        $this->assertSame($filename, $image->getFilename());
    }
}
