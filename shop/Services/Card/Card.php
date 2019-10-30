<?php


namespace shop\Services\Card;


use Doctrine\ORM\EntityManager;
use shop\Dispatchers\EventDispatcher;
use shop\entities\Card\Price;
use shop\entities\Filter\Exceptions\CardFilterDoubleException;
use shop\entities\Filter\Filter;
use shop\entities\Filter\Filters;
use shop\entities\Storage\Transaction\Type;
use shop\repositories\NotFoundException;
use shop\Services\Filter\Filter as FilterService;
use shop\repositories\DoctrineCardRepository;
use shop\entities\Card\Card AS EntityCard;
use shop\entities\Card\Currency;

class Card
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DoctrineCardRepository
     */
    private $repository;
    /**
     * @var FilterService
     */
    private $filterService;

    /**
     * Card constructor.
     * @param EntityManager $em
     * @param EventDispatcher $eventDispatcher
     * @param FilterService $filterService
     */
    public function __construct(EntityManager $em, EventDispatcher $eventDispatcher, FilterService $filterService){

        $this->eventDispatcher = $eventDispatcher;
        $this->em = $em;

        $this->repository = new DoctrineCardRepository($em, $em->getRepository(EntityCard::class));
        $this->filterService = $filterService;
    }


    /**
     * @param $name
     * @param Price $price
     * @param Filter $filter
     * @return EntityCard
     * @throws \Exception
     */
    public function create($name, Price $price, Filter $filter){
        $card = new EntityCard(
            new \DateTime(), $name, $price, Filters::fromItems([$filter])
        );
        $this->repository->add($card);

        $this->eventDispatcher->dispatch($card->releaseEvents());

        return $card;
    }


    /**
     * @param $cardId
     * @param Currency $currency
     * @param int $priceValue
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updatePrice($cardId, Currency $currency, $priceValue){

        $card = $this->get($cardId);

        $card->changePrice(new Price($currency, $priceValue));

        $this->repository->save($card);

        $this->eventDispatcher->dispatch($card->releaseEvents());
    }


    /**
     * @param int $cardId
     * @param string $name
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateName($cardId, $name){

        $card = $this->get($cardId);

        $card->rename($name);

        $this->repository->save($card);

        $this->eventDispatcher->dispatch($card->releaseEvents());
    }

    /**
     * @param int $id
     * @return EntityCard
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id){
        $card = $this->repository->removeById($id);

        $this->eventDispatcher->dispatch($card->releaseEvents());

        return $card;
    }

    /**
     * @return EntityCard[]
     */
    public function getAll(){
        return $this->repository->getAll();
    }


    /**
     * @param int $id
     * @return EntityCard
     * @throws NotFoundException
     */
    public function get($id){
        return $this->repository->get($id);
    }

    /**
     * @param $cardId
     * @param $filterId
     * @throws \Doctrine\ORM\OptimisticLockException | NotFoundException
     */
    public function addFilter($cardId, $filterId){
        $card = $this->repository->get($cardId);
        $card->addFilter($this->filterService->get($filterId));

        try{
            $this->repository->save($card);
            $this->eventDispatcher->dispatch($card->releaseEvents());
        }catch(
        \Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){
            throw new CardFilterDoubleException();
        }
    }

    /**
     * @param int $cardId
     * @param int $filterId
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeFilter($cardId, $filterId){
        $card = $this->get($cardId);
        $card->removeFilter($this->filterService->get($filterId));

        $this->repository->save($card);
        $this->eventDispatcher->dispatch($card->releaseEvents());
    }


    /**
     * @param int $cardId
     * @param string $type
     * @param int $amount
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addTransaction($cardId, $type, $amount){
        $card = $this->get($cardId);
        $card->addTransaction(new Type($type), $amount);

        $this->repository->save($card);

        $this->eventDispatcher->dispatch($card->releaseEvents());
    }

    public function getCardsToSelectOptions(){

        $qb = $this->em->createQueryBuilder();

        $qb->select('c.id, c.name')
        ->from('shop\entities\Card\Card', 'c')
        ->orderBy('c.name', 'asc');

        return array_map(function($row){
            return ['value' => $row['id'], 'label' => $row['name']];
        }, $qb->getQuery()->execute());
    }
}