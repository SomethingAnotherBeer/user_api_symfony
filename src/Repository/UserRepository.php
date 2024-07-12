<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\From;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }



        public function saveUser(User $user): void
        {
            $em = $this->getEntityManager();

            $em->persist($user);
            $em->flush();
        }

        public function removeUser(User $user): void
        {
            $em = $this->getEntityManager();

            $em->remove($user);
            $em->flush();
        }

        public function getUserById(int $user_id): ?User
        {
            return $this->findOneBy(['id' => $user_id]);
        }

        public function getMaxUserId(): ?int
        {
            $qb = $this->getEntityManager()->createQueryBuilder();

            $res = $qb->select("MAX(u.id) AS max_user_id")
                    ->from(User::class, 'u')
                    ->getQuery()
                    ->getResult();

            return ($res) ? (int)$res[0]['max_user_id'] : null;

        }


        public function checkUserByLogin(string $user_login): bool
        {
            return ($this->findOneBy(['login' => $user_login])) ? true : false;
        }

        public function checkUserByEmail(string $user_email): bool
        {
            return ($this->findOneBy(['email' => $user_email])) ? true : false;
        }

}
