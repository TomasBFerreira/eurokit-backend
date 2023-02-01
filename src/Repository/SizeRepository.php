<?php

namespace App\Repository;

use App\Entity\Size;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Size::class);
    }

    // /**
    //  * @return Size[] Returns an array of Property objects
    //  */
    
    public function findWithModel(string $id): ?Size
    {
        $alias = 's';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('s.id = :id')
                ->join('s.model', 'm')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getResult();
        
        return $result[0] ?? null;        
    }
    
    public function findAllWithModels(): array
    {
        $alias = 's';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->join('s.model', 'm')
                ->getQuery();
        
        $result = $query->getResult();
        
        return $result;        
    }
    
      public function findWithManyProducts(string $id): array
    {
        $alias = 's';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('s.model = :id')
                ->join('p.size', 's')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getResult();
        
        return $result;        
    }
}

