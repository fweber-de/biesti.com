<?php

namespace fweber\DataBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findAllPublished($paginator, $page, $limit)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('fweberDataBundle:Post', 'p')
            ->where('p.isDraft = false')
            ->andWhere('p.publishDate <= :now')
            ->orderBy('p.publishDate', 'desc')
            ->setParameters(
                array(
                    'now' => new \DateTime('now'),
                )
            );

        $posts = $paginator->paginate(
            $qb, $page, $limit
        );

        return $posts;
    }
}
