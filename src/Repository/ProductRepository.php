<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    public function findByDistributionDate($distributionDateStr)
    {
        $dateTime = date_create($distributionDateStr);

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            WHERE p.distributionDate = :distribution
            ORDER BY p.name ASC'
        )->setParameter('distribution', $dateTime);

        // returns an array of Product objects
        return $query->execute();
    }
   

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
