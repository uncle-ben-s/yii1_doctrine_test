<?php


namespace shop\repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use shop\entities\Card\Card;

class DoctrineCardRepository implements CardRepository
{
    private $em;
    private $entityRepository;

    public function __construct(EntityManager $em, EntityRepository $entityRepository)
    {
        $this->em = $em;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param int $id
     * @return Card
     */
    public function get($id)
    {
        /** @var Card $card */
        if (!$card = $this->entityRepository->find($id)) {
            throw new NotFoundException('Card not found.');
        }
        return $card;
    }

    /**
     * @return Card[]
     */
    public function getAll()
    {
        /** @var Card[] $cards */
        if (!$cards = $this->entityRepository->findAll()) {
            throw new NotFoundException('Cards not found.');
        }
        return $cards;
    }

    public function add(Card $card)
    {
        $this->em->persist($card);
        $this->em->flush($card);
    }

    /**
     * @param Card $card
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Card $card)
    {
        $this->em->flush($card);
    }

    public function remove(Card $card)
    {
        $this->em->remove($card);
        $this->em->flush($card);
    }
}