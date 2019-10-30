<?php


namespace shop\repositories;

use shop\entities\History\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use shop\repositories\Interfaces\HistoryTypeRepository;

class DoctrineHistoryTypeRepository implements HistoryTypeRepository
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
     * @return Type
     */
    public function get($id)
    {
        /** @var Type $type */
        if (!$type = $this->entityRepository->find($id)) {
            throw new NotFoundException('History type not found.');
        }
        return $type;
    }


    /**
     * @return Type[]
     */
    public function getAll()
    {
        /** @var Type[] $types */
        if (!$types = $this->entityRepository->findAll()) {
            throw new NotFoundException('History types not found.');
        }
        return $types;
    }

    /**
     * @param Type $type
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Type $type)
    {
        $this->em->persist($type);
        $this->em->flush($type);
    }


    /**
     * @param string $typeName
     * @return Type
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getByName($typeName){
        $type = $this->entityRepository->findOneBy(['name' => $typeName]);

        if(is_null($type)){
            $this->add($type = new Type($typeName));
            return $this->get($type->getId());
        }

        /** @var Type $type */
        return $type;
    }
}