<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * 
     * @return Product[]
     */
    public function findWithSeries(string $id): ?Product
    {
        $alias = 'p';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('p.id = :id')
                ->join('p.series', 's')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getResult();
        
        return $result[0] ?? null;        
    }
    
    public function findAllWithSeries(): array
    {
        $alias = 'p';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->join('p.series', 's')
                ->getQuery();
        
        $result = $query->getResult();
        
        return $result;        
    }
    
    public function findWithManyProducts(string $id): ?Product
    {
        $alias = 'p';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('p.id = :id')
                ->join('p.series', 's')
                ->join('p.models', 'm')
                ->join('m.properties', 'pr')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getOneOrNullResult();
        
        return $result;        
    }
}
