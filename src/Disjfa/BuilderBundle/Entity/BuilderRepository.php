<?php

namespace Disjfa\BuilderBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BuilderRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class BuilderRepository extends EntityRepository
{
    /**
     * @param BuilderQuery $builderQuery
     * @return Builder[]
     */
    public function findByBuilderQuery(BuilderQuery $builderQuery)
    {
        $qb = $this->createQueryBuilder('builder');

        if($builderQuery->getAuthor()) {
            $qb->andWhere('builder.author = :author');
            $qb->setParameter('author', $builderQuery->getAuthor());
        }

        if(null !== $builderQuery->isPreferred()) {
            $qb->andWhere('builder.preferred = :preferred');
            $qb->setParameter('preferred', $builderQuery->isPreferred());
        }

        return $qb->getQuery()->getResult();
    }

}
