<?php

namespace AppBundle\Repository;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * EpisodeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EpisodeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findNextDiffusions()
    {
        return $this->createQueryBuilder('episode')
            ->where("episode.date > :today")
            ->orderBy("episode.date", "ASC")
            ->setParameter('today', date("Y-m-d", time()))
            ->getQuery()
            ->getResult();
    }
}
