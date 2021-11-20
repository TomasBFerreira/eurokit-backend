<?php

namespace App\Controller;

use App\Entity\Model;
use App\Repository\ModelRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelController extends AbstractController
{
    private ModelRepository $repository;
    
    public function __construct(ProductRepository $repository)
        {
        $this->repository = $repository;
        }
    /**
     * @Route("/models", name="models")
     */
    public function index(): Response
    {
        $result = [];
        
        /** @var Product $model */
        foreach ($this->repository->findAll() as $model)
            {
            $result[] = ['id'=> $model->getId(), 'name'=> $model->getName()];
            }
        
        return new JsonResponse($result);
    }
    
     /**
     * @Route("/models/{id}", name="models/view")
     */
    public function view(string $id): Response
    {
        $model = $this->repository->find($id);
        
        if ($model === null){
            return new JsonResponse([error=>"Model not found"], 404);
            }
        return new JsonResponse($model);
    }
}
