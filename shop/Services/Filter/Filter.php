<?php


namespace shop\Services\Filter;

use Doctrine\ORM\EntityManager;
use shop\repositories\DoctrineFilterRepository;
use shop\entities\Filter\Filter AS EntityFilter;
use shop\repositories\NotFoundException;

class Filter
{

    /**
     * @var FilterType
     */
    private $filterTypeService;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineFilterRepository
     */
    private $repository;


    /**
     * History constructor.
     * @param EntityManager $em
     * @param FilterType $filterTypeService
     */
    public function __construct(EntityManager $em, FilterType $filterTypeService){
        $this->em = $em;

        $this->repository = new DoctrineFilterRepository($em, $em->getRepository(EntityFilter::class));
        $this->filterTypeService = $filterTypeService;
    }

    public function create($filterTypeId, $value){
        $this->repository->add(new EntityFilter($this->filterTypeService->get($filterTypeId), $value));
    }

    public function update($filterId, $filterTypeId, $value){
        $filter = $this->get($filterId);
        $filter->changeFilterType($this->filterTypeService->get($filterTypeId));
        $filter->changeValue($value);

        $this->repository->save($filter);
    }

    public function delete($id){
        return $this->repository->removeById($id);
    }

    public function getAll(){
        return $this->repository->getAll();
    }

    /**
     * @param $id
     * @return EntityFilter
     * @throws NotFoundException
     */
    public function get($id){
        return $this->repository->get($id);
    }
}