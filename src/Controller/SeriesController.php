<?php

namespace App\Controller;

use App\Extractor\SeriesExtractor;
use App\Entity\Series;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{

    private SeriesRepository $repository;
    private SeriesExtractor $extractor;

    public function __construct(SeriesRepository $repository, SeriesExtractor $extractor)
    {
        $this->repository = $repository;
        $this->extractor = $extractor;
    }

    /**
     * @Route("/series", name="series")
     */
    public function index(): Response
    {
        $result = [];

        /** @var Series $series */
        foreach ($this->repository->findAll() as $series) {

            $result[] = $this->extractor->extract($series, true);
            if ($result === null) {
                return new JsonResponse([error => "Series not found"], 404);
            }
        }

        return new JsonResponse($result);
    }
    
     /**
     * @Route("/series/{id}", name="series/view")
     */
    public function view(string $id): Response
    {
        $series = $this->repository->findOneById($id);

        if ($series === null) {
            return new JsonResponse([error => "Series not found"], 404);
        }

        $data = $this->extractor->extract($series, true);

        return new JsonResponse($data);
    }

}
