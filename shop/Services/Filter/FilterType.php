<?php


namespace shop\Services\Filter;

use Doctrine\ORM\EntityManager;
use shop\Dispatchers\EventDispatcher;
use shop\repositories\DoctrineFilterTypeRepository;
use shop\entities\Filter\FilterType AS EntityFilterType;
use shop\repositories\NotFoundException;

class FilterType
{
    /**
     * @var EventDispatcher
     */
//    private $eventDispatcher;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineFilterTypeRepository
     */
    private $repository;

    /**
     * Card constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em/*, EventDispatcher $eventDispatcher*/){

//        $this->eventDispatcher = $eventDispatcher;
        $this->em = $em;

        $this->repository = new DoctrineFilterTypeRepository($em, $em->getRepository(EntityFilterType::class));
    }

    public function create($name){
        $filterType = new EntityFilterType($name);

        $this->repository->add($filterType);

//        $this->eventDispatcher->dispatch($filterType->releaseEvents());
    }

    public function delete($id){
        return $this->repository->removeById($id);
    }

    public function getAll(){
        return $this->repository->getAll();
    }

    public function get($id){
        return $this->repository->get($id);
    }

    /**
     * @param int $id
     * @return \shop\entities\Filter\Filter[]|[]
     */
    public function getFilters($id){
        try{
            return $this->get($id)->getFilters();
        }catch(NotFoundException $e){
            return [];
        }
    }
}