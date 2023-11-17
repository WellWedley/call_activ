<?php

namespace App\Repository;

use App\Entity\Friends;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Friends>
 *
 * @method Friends|null find($id, $lockMode = null, $lockVersion = null)
 * @method Friends|null findOneBy(array $criteria, array $orderBy = null)
 * @method Friends[]    findAll()
 * @method Friends[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendsRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Friends::class);
    }

    /**
     * @param Friends $entity
     * @param bool $flush
     *
     * @return void
     */
    public function save(Friends $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Friends $entity
     * @param bool $flush
     *
     * @return void
     */
    public function remove(Friends $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
