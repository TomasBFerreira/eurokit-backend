<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    private SeriesRepository $repository;
    
    public function __construct(SeriesRepository $repository)
        {
        $this->repository = $repository;
        }
    /**
     * @Route("/series", name="series")
     */
    public function index(): Response
    {
        $result = [];
        
        /** @var Series $series */
        foreach ($this->repository->findAll() as $series)
            {
            $result[] = ['id'=> $series->getId(), 'name'=> $series->getName()];
            }
        
        return $this->json($result);
    }
}
