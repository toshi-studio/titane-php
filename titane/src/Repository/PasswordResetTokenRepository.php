<?php

namespace App\Repository;

use App\Entity\PasswordResetToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PasswordResetToken>
 */
class PasswordResetTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordResetToken::class);
    }

    /**
     * Find valid token by UID
     */
    public function findValidToken(string $tokenUid): ?PasswordResetToken
    {
        return $this->createQueryBuilder('prt')
            ->andWhere('prt.tokenUid = :tokenUid')
            ->andWhere('prt.expiresAt > :now')
            ->andWhere('prt.usedAt IS NULL')
            ->setParameter('tokenUid', $tokenUid)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Clean up expired tokens
     */
    public function deleteExpiredTokens(): int
    {
        return $this->createQueryBuilder('prt')
            ->delete()
            ->where('prt.expiresAt < :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->execute();
    }
}
