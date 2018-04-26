<?php

/*
 *  This file is licensed under the MIT License version 3 or
 *  later. See the LICENSE file for details.
 *
 *  Copyright 2018 Michael Joyce <ubermichael@gmail.com>.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Au;
use Doctrine\ORM\EntityRepository;

/**
 * AuRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AuRepository extends EntityRepository {

    /**
     * @param string $auid
     *
     * @return Au|null
     */
    public function findOpenAu($auid) {
        $qb = $this->createQueryBuilder('au');
        $qb->andWhere('au.auid = :auid');
        $qb->setParameter('auid', $auid);
        $qb->andWhere('au.open = true');
        $qb->orderBy('au.id', 'ASC');
        $qb->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }

}
