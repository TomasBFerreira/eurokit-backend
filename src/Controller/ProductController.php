<?php

namespace App\Controller;

use Doctrine\Common\Collections\Collection;
use App\Extractor\ProductExtractor;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Entity\Property;
use App\Entity\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    /**
     * @Route("/product/{id}", name="product/view")
     */
    public function productView(string $id): Response
    {


        $product = $this->repository->findWithManyProducts($id);

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        $data = $this->extractProduct($product);

        return new JsonResponse($data);
    }

    private function extractProduct(Product $product): array
    {
        $models = $product->getModels();

        $data = [
            'name' => $product->getName(),
            'models' => $this->extractModels($models)
        ];

        return $data;
    }

    private function extractModels(Collection $models): array
    {
        $data = [];
        
        foreach ($models as $model) {
            $data[] = $this->extractModel($model);
        }
        return $data;
    }
    
    private function extractModel(Model $model): array
    {
        $properties = $model->getProperties();
        
        $data = [
            'code' => $model->getCode(),
            'description' => $model->getDescription(),
            'sizes' => $model->getSizes(),
            'properties' => $this->extractProperties($properties)
        ];
                
        return $data;
    }
    
    private function extractProperties(Collection $properties): array
    {
        $data = [];
        
        foreach ($properties as $property){
            $name = $property->getName();
            $value = $property->getValue();
            
            $data[$name] = $value;
        }
        
        return $data;
    }
}
