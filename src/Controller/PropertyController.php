<?php
namespace App\Controller;

use App\Entity\Property;
use App\Entity\Model;
use App\Extractor\PropertyExtractor;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    private PropertyRepository $repository;
    private PropertyExtractor $extractor;

    public function __construct(PropertyRepository $repository, PropertyExtractor $extractor)
    {
        $this->repository = $repository;
        $this->extractor = $extractor;
    }

    /**
     * @Route("/properties", name="properties")
     */
    public function index(): Response
    {
        $result = [];

        /** @var Property $property */
        foreach ($this->repository->findAllWithModels() as $property) {
            $result[] = $this->extractor->extract($property, true);
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/properties/{id}", name="properties/view")
     */
    public function view(string $id): Response
    {
        $property = $this->repository->findWithModel($id);

        if ($property === null) {
            return new JsonResponse([error => "Product not found"], 404);
        }

        $data = $this->extractor->extract($property, true);

        return new JsonResponse($data);
    }

    /**
     * @Route("/product/{id}", name="product/view")
     
    public function productView(string $id): Response
    {
        $data = [];
        
        foreach ($this->repository->findWithManyProducts($id) as $model){
            $data[] = $this->extractor->extract($model, true);
        }
        

        

        return new JsonResponse($data);
    }
*/
}
