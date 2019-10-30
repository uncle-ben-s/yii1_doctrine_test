<?php


namespace shop\Services\User;

use Doctrine\ORM\EntityManager;
use shop\entities\User\Role AS EntityRole;
use shop\repositories\DoctrineRoleRepository;
use shop\repositories\NotFoundException;

class Role
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineRoleRepository
     */
    private $repository;


    /**
     * History constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;

        $this->repository = new DoctrineRoleRepository($em, $em->getRepository(EntityRole::class));
    }

    /**
     * @param string $name
     * @return EntityRole
     */
    public function getByName($name){

        try{
            return $this->repository->getByName($name);
        }catch(NotFoundException $e){

        }

        return new EntityRole($name);
    }
}