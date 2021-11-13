<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductRepository $repository;
    
    public function __construct(ProductRepository $repository)
        {
        $this->repository = $repository;
        }
    /**
     * @Route("/products", name="products")
     */
    public function index(): Response
    {
        $result = [];
        
        /** @var Product $product */
        foreach ($this->repository->findAll() as $product)
            {
            $result[] = ['id'=> $product->getId(), 'name'=> $product->getName()];
            }
        
        return new JsonResponse($result);
    }
    
     /**
     * @Route("/products/{id}", name="products/view")
     */
    public function view(string $id): Response
    {
        $product = $this->repository->find($id);
        
        if ($product === null){
            return new JsonResponse([error=>"Product not found"], 404);
            }
        return new JsonResponse($product);
    }
}
