<?php


namespace shop\Services\History;


use Doctrine\ORM\EntityManager;
use shop\entities\History\Type;
use shop\repositories\DoctrineHistoryTypeRepository;

class HistoryType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineHistoryTypeRepository
     */
    private $repository;


    /**
     * History constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;

        $this->repository = new DoctrineHistoryTypeRepository($em, $em->getRepository(Type::class));
    }

    /**
     * @param string $name
     * @return Type
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getByName($name){
        return $this->repository->getByName($name);
    }

    /**
     * @return Type[]
     */
    public function getAll(){
        return $this->repository->getAll();
    }


    /**
     * @param int $id
     * @return Type
     */
    public function get($id){
        return $this->repository->get($id);
    }



    public function getTypesToSelectOptions(){

        $qb = $this->em->createQueryBuilder();

        $qb->select('t.id, t.name')
        ->from('shop\entities\History\Type', 't')
            ->orderBy('t.name', 'asc');

        return array_map(function($row){
            return ['value' => $row['id'], 'label' => $row['name']];
        }, $qb->getQuery()->execute());
    }
}