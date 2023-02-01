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

        return new JsonResponse(json_encode($result, JSON_PRETTY_PRINT), 200, [], true);
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

        $options = JSON_PRETTY_PRINT;
        return new JsonResponse(json_encode($data, $options), 200, [], true);
    }

    /**
     * @Route("/product/{id}", name="product/view")
     */
    public function productView(string $id): Response
    {


        $product = $this->repository->findWithManyProducts($id);
        $model = $this->repository->extractProduct($models);


        if ($product === null) {
            throw new NotFoundHttpException();
        }

<<<<<<< HEAD
        $data = $this->extractProduct($product, $model, $properties, $sizes);

        $options = JSON_PRETTY_PRINT;
        return new JsonResponse(json_encode($data, $options), 200, [], true);
=======
        $data = $this->extractProduct($product);

        return new JsonResponse($data);
>>>>>>> d03895a0cf1a9ad57991b91f2c0ddcc09529d593
    }

    private function extractProduct(Product $product, Model $model, Porperties $properties, Sizes $sizes): array
    {
        $models = $product->getModels();
        $properties = $model->getProperties();

        $data = [
            'name' => $product->getName(),
            'models' => $model->getModel(),
            'code' => $this->extractProperties($properties)
        ];

        return $data;
    }

    private function extractModels(Collection $models): self
    {
        $data = [];
        
        foreach ($models as $model) {
            $data[] = $this->extractModel($model);
        }
        return $data;
    }
    
    private function extractModel(Model $model): self
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
    
    private function extractProperties(Collection $properties): self
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
