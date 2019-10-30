<?php


namespace shop\Services\History;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use shop\entities\History\History as EntityHistory;
use shop\repositories\DoctrineHistoryRepository;
use shop\Services\Card\Card;
use shop\Services\User\User;

class History
{
    /**
     * @var Card
     */
    private $cardService;
    /**
     * @var HistoryType
     */
    private $historyTypeService;
    /**
     * @var User
     */
    private $userService;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineHistoryRepository
     */
    private $repository;


    /**
     * History constructor.
     * @param EntityManager $em
     * @param Card $cardService
     * @param HistoryType $historyTypeService
     * @param User $userService
     */
    public function __construct(
        EntityManager $em,
        Card $cardService,
        HistoryType $historyTypeService,
        User $userService
    ){
        $this->em = $em;

        $this->repository = new DoctrineHistoryRepository($em, $em->getRepository(EntityHistory::class));
        $this->cardService = $cardService;
        $this->historyTypeService = $historyTypeService;
        $this->userService = $userService;
    }

    /**
     * @return EntityHistory[]
     */
    public function getAll(){
        return $this->repository->getAll();
    }


    /**
     * @param int $id
     * @return EntityHistory
     */
    public function get($id){
        return $this->repository->get($id);
    }

    /**
     * @param $cardId
     * @param $typeName
     * @param $userId
     * @param $info
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create($cardId, $typeName, $userId, $info){
        $history = new EntityHistory(
            $this->cardService->get($cardId),
            $this->historyTypeService->getByName($typeName),
            $this->userService->get($userId),
            new \DateTime(),
            $info
        );

        $this->repository->add($history);
    }

    public function countAll(){
        return (int) $this->repository->count();
    }

    public function getTables($request){

        $offset = $request['start'];

        $limit = $request['length'];

        $orderBy = [];

        $columns = $request['columns'];

        if($orders = $request['order']){
            foreach($orders as $order){
                if(array_key_exists($order['column'], $columns)){
                    $orderBy = ['sort' => $columns[$order['column']]['name'], 'order' => $order['dir']];
                }
            }
        }

        $qb = $this->em->getRepository(EntityHistory::class)->createQueryBuilder('h');

        $qb->join('h.type', 't')
        ->join('h.card', 'c')
        ->join('h.user', 'u')
        ->join('u.role', 'r')
        ->setFirstResult($offset)
        ->setMaxResults($limit);

        if(count($orderBy)){
            $qb->orderBy($orderBy['sort'], $orderBy['order']);
        }

        foreach($this->getSearch($columns) as $key => $search){
            $qb->andWhere($search['field'] . $search['operation'] . ':' . str_replace('.','',$search['field']) . $key);
            $qb->setParameter(str_replace('.','',$search['field']) . $key, $search['value']);
        }

        $histories = [];

        $paginator = new Paginator($qb->getQuery(), $fetchJoinCollection = false);

        try{
            /** @var \shop\entities\History\History $history */
            foreach($paginator as $history){
                $histories[] = [
                    $history->getId(),
                    $history->getType()->getName(),
                    $history->getCard()->getName(),
                    $history->getUser()->getRole()->getName() . ' ' . $history->getUser()->getEmail(),
                    $history->getCreateDate()->format('Y-m-d H:i:s'),
                    $history->getInfo(),
                ];
            }
        }catch(\Exception $e){
            \Yii::app()->user->setFlash('info', $e->getMessage());
        }

        return [
            'draw' => $request['draw'],
            "recordsTotal" => $this->countAll(),
            "recordsFiltered" => count($paginator),
            'data' => $histories
        ];
    }

    private function getSearch(&$columns){
        $where = [];
        foreach($columns as $column){
            if(!empty($column['searchable']) && !empty($column['search']['value'])){
                if(strlen($column['search']['value']) === strlen(str_replace('-yadcf_delim-', '',$column['search']['value']))){
                    $tableName = explode('.', $column['name'])[0];
                    $where[] = ['field' => $tableName . '.id', 'operation' => '=', 'value' => $column['search']['value']];
                }else{

                    list($minDate, $maxDate) = explode('-yadcf_delim-', $column['search']['value']);

                    if(!empty($minDate)){
                        $where[] = ['field' => $column['name'], 'operation' => '>=', 'value' => $minDate .  ' 00:00:00'];
                    }
                    if(!empty($maxDate)){
                        $where[] = ['field' => $column['name'], 'operation' => '<=', 'value' => $maxDate . ' 23:59:59'];
                    }
                }
            }
        }

        return $where;
    }
}