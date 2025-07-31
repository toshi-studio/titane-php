<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * Find a project by its UID
     */
    public function findOneByUid(string $uid): ?Project
    {
        return $this->findOneBy(['uid' => $uid]);
    }

    /**
     * Find all active (non-archived) projects
     */
    public function findActiveProjects(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isArchived = :archived')
            ->setParameter('archived', false)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find projects by user and role
     */
    public function findByUserAndRole(int $userId, ?string $role = null): array
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.userRoles', 'upr')
            ->andWhere('upr.user = :userId')
            ->setParameter('userId', $userId);

        if ($role !== null) {
            $qb->andWhere('upr.role = :role')
               ->setParameter('role', $role);
        }

        return $qb->orderBy('p.name', 'ASC')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Find projects by user UID and role for API access
     * 
     * This method allows API endpoints to retrieve projects for a user
     * using their external UID identifier instead of internal database ID.
     * 
     * @param string $userUid The user's unique identifier (UUID format)
     * @param string|null $role Optional role filter (super_admin, admin, co_admin)
     * 
     * @return Project[] Array of projects matching the criteria
     */
    public function findByUserUidAndRole(string $userUid, ?string $role = null): array
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.userRoles', 'upr')
            ->innerJoin('upr.user', 'u')
            ->andWhere('u.uid = :userUid')
            ->setParameter('userUid', $userUid);

        if ($role !== null) {
            $qb->andWhere('upr.role = :role')
               ->setParameter('role', $role);
        }

        return $qb->orderBy('p.name', 'ASC')
                  ->getQuery()
                  ->getResult();
    }
}