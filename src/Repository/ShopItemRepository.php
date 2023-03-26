<?php

namespace App\Repository;

use App\Entity\ShopItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShopItem>
 *
 * @method ShopItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopItem[]    findAll()
 * @method ShopItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopItem::class);
    }

    public function save(ShopItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShopItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function itemCreate(EntityManagerInterface $entityManager, $title,$price,$description)
    {
        $shoe = new ShopItem();
        $shoe->setTitle($title);
        $shoe->setDescription($description);
        $shoe->setPrice($price);
        $entityManager->persist($shoe);
        $entityManager->flush();
    }


//    /**
//     * @return ShopItem[] Returns an array of ShopItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ShopItem
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
