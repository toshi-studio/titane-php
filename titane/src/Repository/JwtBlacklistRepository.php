<?php

namespace App\Repository;

use App\Entity\JwtBlacklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JwtBlacklist>
 */
class JwtBlacklistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JwtBlacklist::class);
    }

    /**
     * Check if JWT token is blacklisted
     */
    public function isTokenBlacklisted(string $jti): bool
    {
        $result = $this->findOneBy(['jti' => $jti]);
        return $result !== null;
    }

    /**
     * Clean up expired blacklist entries
     */
    public function deleteExpiredEntries(): int
    {
        return $this->createQueryBuilder('jb')
            ->delete()
            ->where('jb.expiresAt < :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->execute();
    }
}
