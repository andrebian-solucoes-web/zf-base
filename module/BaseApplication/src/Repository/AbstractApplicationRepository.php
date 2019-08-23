<?php

namespace BaseApplication\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;

/**
 * Class AbstractApplicationRepository
 * @package BaseApplication\Repository
 */
abstract class AbstractApplicationRepository extends EntityRepository implements ApplicationRepositoryInterface
{
    /**
     * @param array $data
     * @param array $orderOptions
     * @return mixed
     */
    public function search(array $data, $orderOptions = [])
    {
        $active = isset($data['active']) ? $data['active'] : true;
        unset($data['active']);

        $qb = $this->createQueryBuilder('o')
            ->where('o.active = :active')
            ->setParameter('active', $active);

        if (! empty($data)) {
            foreach ($data as $criteria => $value) {
                if (is_object($value)) {
                    $qb->andWhere('o.' . $criteria . ' = :' . $criteria);
                    $qb->setParameter($criteria, $value);
                } elseif (is_string($value)) {
                    $qb->andWhere($qb->expr()->like('o.' . $criteria, $qb->expr()->literal('%' . $value . '%')));
                }
            }
        }

        if (! empty($orderOptions)) {
            foreach ($orderOptions as $name => $order) {
                $qb->add('orderBy', 'o.' . $name . ' ' . $order);
            }
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return int
     */
    public function countActive()
    {
        $entityName = (string)$this->getEntityName();
        /** @var Query $query */
        $query = $this->getEntityManager()
            ->createQuery('SELECT COUNT(u.id) FROM ' . $entityName . ' u WHERE u.active=true');
        try {
            $count = $query->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            $count = 0;
        }

        return $count;
    }

    /**
     * @return int
     */
    public function countInactive()
    {
        $entityName = (string)$this->getEntityName();
        /** @var Query $query */
        $query = $this->getEntityManager()
            ->createQuery('SELECT COUNT(u.id) FROM ' . $entityName . ' u WHERE u.active=false');
        try {
            $count = $query->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            $count = 0;
        }

        return $count;
    }
}
