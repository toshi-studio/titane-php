<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * UserRepository handles database operations for User entities
 * 
 * Provides methods for user authentication, password management, and user queries
 * with proper security considerations and performance optimization.
 * 
 * @extends ServiceEntityRepository<User>
 * 
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Upgrades (rehashes) the user's password automatically over time for improved security
     * 
     * This method is called by Symfony's security system when a user logs in with an
     * outdated password hash format. It automatically upgrades to the current hash algorithm.
     * 
     * @param PasswordAuthenticatedUserInterface $user The user whose password needs upgrading
     * @param string $newHashedPassword The new hashed password using current algorithm
     * 
     * @return void
     * 
     * @throws UnsupportedUserException If the provided user is not a User entity instance
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Finds a user by email address using case-insensitive comparison
     * 
     * This method is essential for authentication as it handles email matching
     * regardless of case variations that users might enter.
     * 
     * @param string $email The email address to search for
     * 
     * @return User|null The user if found, null otherwise
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('LOWER(u.email) = LOWER(:email)')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retrieves all active (non-disabled) users ordered by creation date
     * 
     * This method filters out deactivated user accounts and returns only
     * users who can currently access the system.
     * 
     * @return User[] Array of active User entities ordered by creation date (newest first)
     */
    public function findActiveUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.isActive = :active')
            ->setParameter('active', true)
            ->orderBy('u.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds a user by their unique identifier (UID) for API access
     * 
     * This method is essential for API operations as external systems
     * will use UIDs instead of internal database IDs for user identification.
     * 
     * @param string $uid The user's unique identifier (UUID format)
     * 
     * @return User|null The user if found, null otherwise
     */
    public function findOneByUid(string $uid): ?User
    {
        return $this->findOneBy(['uid' => $uid]);
    }
}
