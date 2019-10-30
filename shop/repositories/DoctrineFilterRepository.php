<?php


namespace shop\repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use shop\entities\Filter\Filter;

class DoctrineFilterRepository implements FilterRepository
{
    private $em;
    private $entityRepository;

    public function __construct(EntityManager $em, EntityRepository $entityRepository)
    {
        $this->em = $em;
        $this->entityRepository = $entityRepository;
    }


    /**
     * @param int $id
     * @return Filter
     * @throws NotFoundException
     */
    public function get($id)
    {
        /** @var Filter $filter */
        if (!$filter = $this->entityRepository->find($id)) {
            throw new NotFoundException('Filter not found.');
        }
        return $filter;
    }

    /**
     * @return Filter[]
     */
    public function getAll()
    {
        /** @var Filter[] $filters */
        if (!$filters = $this->entityRepository->findAll()) {
            throw new NotFoundException('Filters not found.');
        }
        return $filters;
    }

    public function add(Filter $filter)
    {
        $this->em->persist($filter);
        $this->em->flush($filter);
    }

    public function save(Filter $filter)
    {
        $this->em->flush($filter);
    }

    public function remove(Filter $filter)
    {
        $this->em->remove($filter);
        $this->em->flush($filter);

        return $filter;
    }

    public function removeById($filterId)
    {
        return $this->remove($this->get($filterId));
    }
}