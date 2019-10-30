<?php


namespace shop\repositories;

use shop\entities\History\History;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use shop\repositories\Interfaces\HistoryRepository;

class DoctrineHistoryRepository implements HistoryRepository
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * DoctrineCurrencyRepository constructor.
     * @param EntityManager $em
     * @param EntityRepository $entityRepository
     */
    public function __construct(EntityManager $em, EntityRepository $entityRepository)
    {
        $this->em = $em;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param int $id
     * @return History
     */
    public function get($id)
    {
        /** @var History $history */
        if (!$history = $this->entityRepository->find($id)) {
            throw new NotFoundException('History type not found.');
        }
        return $history;
    }


    /**
     * @return History[]
     */
    public function getAll()
    {
        /** @var History[] $histories */
        if (!$histories = $this->entityRepository->findAll()) {
            throw new NotFoundException('History types not found.');
        }
        return $histories;
    }

    /**
     * @param History $history
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(History $history)
    {
        $this->em->persist($history);
        $this->em->flush($history);
    }

    public function count(){
        return $this->entityRepository->createQueryBuilder('t')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}