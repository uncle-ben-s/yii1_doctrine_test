<?php


namespace shop\repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use shop\entities\Filter\Exceptions\FilterTypeDoubleException;
use shop\entities\Filter\FilterType;

class DoctrineFilterTypeRepository implements FilterTypeRepository
{
    private $em;
    private $entityRepository;

    /**
     * DoctrineFilterTypeRepository constructor.
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
     * @return FilterType
     */
    public function get($id)
    {
        /** @var FilterType $filterType */
        if (!$filterType = $this->entityRepository->find($id)) {
            throw new NotFoundException('FilterType not found.');
        }
        return $filterType;
    }

    /**
     * @return FilterType[]
     */
    public function getAll()
    {
        /** @var FilterType[] $filterTypes */
        if (!$filterTypes = $this->entityRepository->findAll()) {
            throw new NotFoundException('FilterTypes not found.');
        }
        return $filterTypes;
    }

    public function add(FilterType $filterType)
    {
        if(!is_null($this->entityRepository->findOneBy(['name' => $filterType->getName()]))){
            throw new FilterTypeDoubleException();
        }

        $this->em->persist($filterType);
        $this->em->flush($filterType);
    }

    public function remove(FilterType $filterType)
    {
        $this->em->remove($filterType);
        $this->em->flush($filterType);

        return $filterType;
    }

    public function removeById($filterTypeId)
    {
        return $this->remove($this->get($filterTypeId));
    }
}