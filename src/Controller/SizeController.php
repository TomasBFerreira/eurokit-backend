<?php
namespace App\Controller;

use App\Entity\Size;
use App\Entity\Model;
use App\Extractor\SizeExtractor;
use App\Repository\SizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SizeController extends AbstractController
{

    private SizeRepository $repository;
    private SizeExtractor $extractor;

    public function __construct(SizeRepository $repository, SizeExtractor $extractor)
    {
        $this->repository = $repository;
        $this->extractor = $extractor;
    }

    /**
     * @Route("/sizes", name="sizes")
     */
    public function index(): Response
    {
        $result = [];

        /** @var Size $size */
        foreach ($this->repository->findAllWithModels() as $size) {
            $result[] = $this->extractor->extract($size, true);
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/properties/{id}", name="properties/view")
     
    public function view(string $id): Response
    {
        $Size = $this->repository->findWithModel($id);

        if ($Size === null) {
            return new JsonResponse([error => "Product not found"], 404);
        }

        $data = $this->extractor->extract($Size, true);

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
