<?php

namespace BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 */
class PostRepository extends EntityRepository
{
    public function getPost($categorySlug, $postSlug){

        $qb = $this->_em->createQueryBuilder();

        $qb
            ->select('p')
            ->from('BlogBundle:Post', 'p')
            ->leftJoin('p.category', 'c')
            ->where('p.slug = :postslug')
            ->andWhere('c.slug = :categoryslug')
            ->setParameters([
                'postslug' => $postSlug,
                'categoryslug' => $categorySlug
            ]);

        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }
}
