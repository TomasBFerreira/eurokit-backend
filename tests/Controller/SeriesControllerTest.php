<?php

use App\Entity\Series;
use App\Controller\SeriesController;
use App\Repository\SeriesRepository;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class SeriesControllerTest extends TestCase
    {
    public function testIndex()
        {
        $repository = $this->createMock(SeriesRepository::class);
        $series = [new Series()];
        $repository->expects($this->once())->method('findAll')->willReturn($series);
        $this->assertInstanceOf(SeriesRepository::class, $repository);
        
        $controller = new SeriesController($repository);
        $response = $controller->index();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
      
        $this->assertSame(json_encode([["id" => null, "name" => null]]), $response->getContent());
        }
    }
