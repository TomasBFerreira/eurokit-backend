<?php

namespace App\Controller;

use App\Extractor\ModelExtractor;
use App\Entity\Model;
use App\Repository\ModelRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelController extends AbstractController
{
    private ModelExtractor $extractor;
    private ModelRepository $repository;
    
    public function __construct(ModelRepository $repository, ModelExtractor $extractor)
        {
        $this->repository = $repository;
        $this->extractor = $extractor;
        }
    /**
     * @Route("/models", name="models")
     */
    public function index(): Response
    {
        $result = [];

        /** @var Model $model */
        foreach ($this->repository->findAllWithProducts() as $model) {
            $result[] = $this->extractor->extract($model, true);
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/models/{id}", name="models/view")
     */
    public function view(string $id): Response
    {
        $model = $this->repository->findWithProduct($id);

        if ($model === null) {
            return new JsonResponse([error => "Model not found"], 404);
        }

        $data = $this->extractor->extract($model, true);

        return new JsonResponse($data);
    }


}

