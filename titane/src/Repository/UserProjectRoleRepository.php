<?php

namespace App\Repository;

use App\Entity\UserProjectRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserProjectRole>
 *
 * @method UserProjectRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProjectRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProjectRole[]    findAll()
 * @method UserProjectRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProjectRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProjectRole::class);
    }

    /**
     * Find user role for a specific project
     */
    public function findUserProjectRole(int $userId, int $projectId): ?UserProjectRole
    {
        return $this->findOneBy([
            'user' => $userId,
            'project' => $projectId
        ]);
    }

    /**
     * Find all roles for a user
     */
    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('upr')
            ->andWhere('upr.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all users with a specific role in a project
     */
    public function findByProjectAndRole(int $projectId, string $role): array
    {
        return $this->createQueryBuilder('upr')
            ->andWhere('upr.project = :projectId')
            ->andWhere('upr.role = :role')
            ->setParameter('projectId', $projectId)
            ->setParameter('role', $role)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find user project role by user UID and project UID for API access
     * 
     * This method enables API endpoints to check user permissions within a project
     * using external identifiers for both user and project.
     * 
     * @param string $userUid The user's unique identifier (UUID format)
     * @param string $projectUid The project's unique identifier (UUID format)
     * 
     * @return UserProjectRole|null The role assignment if found, null otherwise
     */
    public function findByUserUidAndProjectUid(string $userUid, string $projectUid): ?UserProjectRole
    {
        return $this->createQueryBuilder('upr')
            ->innerJoin('upr.user', 'u')
            ->innerJoin('upr.project', 'p')
            ->andWhere('u.uid = :userUid')
            ->andWhere('p.uid = :projectUid')
            ->setParameter('userUid', $userUid)
            ->setParameter('projectUid', $projectUid)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find all role assignments for a user using user UID for API access
     * 
     * This method allows API endpoints to retrieve all project assignments
     * for a user using their external UID identifier.
     * 
     * @param string $userUid The user's unique identifier (UUID format)
     * 
     * @return UserProjectRole[] Array of role assignments for the user
     */
    public function findByUserUid(string $userUid): array
    {
        return $this->createQueryBuilder('upr')
            ->innerJoin('upr.user', 'u')
            ->andWhere('u.uid = :userUid')
            ->setParameter('userUid', $userUid)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all users with a specific role in a project using project UID for API access
     * 
     * This method enables API endpoints to retrieve users by role within a project
     * using the project's external UID identifier.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $role The role to filter by (super_admin, admin, co_admin)
     * 
     * @return UserProjectRole[] Array of role assignments matching the criteria
     */
    public function findByProjectUidAndRole(string $projectUid, string $role): array
    {
        return $this->createQueryBuilder('upr')
            ->innerJoin('upr.project', 'p')
            ->andWhere('p.uid = :projectUid')
            ->andWhere('upr.role = :role')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('role', $role)
            ->getQuery()
            ->getResult();
    }
}