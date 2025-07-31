<?php

namespace App\Repository;

use App\Entity\FormField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormField>
 */
class FormFieldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormField::class);
    }

    /**
     * Find fields by form ordered by field order
     */
    public function findByFormOrdered(int $formId): array
    {
        return $this->createQueryBuilder('ff')
            ->andWhere('ff.form = :formId')
            ->setParameter('formId', $formId)
            ->orderBy('ff.fieldOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
