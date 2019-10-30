<?php


namespace shop\Services\User;

use Doctrine\ORM\EntityManager;
use shop\entities\User\Password;
use shop\entities\User\Role;
use shop\repositories\DoctrineUserRepository;
use shop\entities\User\User AS EntityUser;

class User
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineUserRepository
     */
    private $repository;


    /**
     * History constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;

        $this->repository = new DoctrineUserRepository($em, $em->getRepository(EntityUser::class));
    }
    /**
     * @param $email
     * @return EntityUser
     */
    public function getByEmail($email){
        return $this->repository->getByEmail($email);
    }

    /**
     * @param int $id
     * @return EntityUser
     */
    public function get($id){
        return $this->repository->get($id);
    }

    public function register($email, $password, $role){

        $user = new EntityUser(new Role($role), $email, new Password(Password::hash($password)));

        $this->repository->add($user);
    }

    public function getAll(){
        return $this->repository->getAll();
    }

    public function getUsersToSelectOptions(){

        $qb = $this->em->createQueryBuilder();

        $qb->select('u.id, u.email')
            ->from('shop\entities\User\User', 'u')
            ->orderBy('u.email', 'asc');

        return array_map(function($row){
            return ['value' => $row['id'], 'label' => $row['email']];
        }, $qb->getQuery()->execute());
    }
}