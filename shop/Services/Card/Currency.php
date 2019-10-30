<?php


namespace shop\Services\Card;


use Doctrine\ORM\EntityManager;
use shop\repositories\DoctrineCurrencyRepository;
use shop\entities\Card\Currency AS EntityCurrency;

class Currency
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineCurrencyRepository
     */
    private $repository;


    /**
     * History constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;

        $this->repository = new DoctrineCurrencyRepository($em, $em->getRepository(EntityCurrency::class));
    }
    /**
     * @param string $name
     * @param string $code
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create($name, $code){
        $this->repository->add(new EntityCurrency($name, $code));
    }

    /**
     * @param int $id
     * @return EntityCurrency
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id){
        return $this->repository->removeById($id);
    }

    /**
     * @return EntityCurrency[]
     */
    public function getAll(){
        return $this->repository->getAll();
    }


    /**
     * @param int $id
     * @return EntityCurrency
     */
    public function get($id){
        return $this->repository->get($id);
    }
}