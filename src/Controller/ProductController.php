<?php

namespace App\Controller;

use App\Extractor\ProductExtractor;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private ProductRepository $repository;
    private ProductExtractor $extractor;

    public function __construct(ProductRepository $repository, ProductExtractor $extractor)
    {
        $this->repository = $repository;
        $this->extractor = $extractor;
    }

    /**
     * @Route("/products", name="products")
     */
    public function index(): Response
    {
        $result = [];

        /** @var Product $product */
        foreach ($this->repository->findAllWithSeries() as $product) {
            $result[] = $this->extractor->extract($product, true);
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/products/{id}", name="products/view")
     */
    public function view(string $id): Response
    {
        $product = $this->repository->findWithSeries($id);

        if ($product === null) {
            return new JsonResponse([error => "Product not found"], 404);
        }

        $data = $this->extractor->extract($product, true);

        return new JsonResponse($data);
    }


}
