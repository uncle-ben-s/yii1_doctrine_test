<?php


namespace shop\repositories;


use shop\entities\Card\Currency;
use shop\repositories\Interfaces\CurrencyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineCurrencyRepository implements CurrencyRepository
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
     * @return Currency
     */
    public function get($id)
    {
        /** @var Currency $currency */
        if (!$currency = $this->entityRepository->find($id)) {
            throw new NotFoundException('Currency not found.');
        }
        return $currency;
    }


    /**
     * @return Currency[]
     */
    public function getAll()
    {
        /** @var Currency[] $currencies */
        if (!$currencies = $this->entityRepository->findAll()) {
            throw new NotFoundException('Currencies not found.');
        }
        return $currencies;
    }

    /**
     * @param Currency $currency
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Currency $currency)
    {
        $this->em->persist($currency);
        $this->em->flush($currency);
    }

    /**
     * @param Currency $currency
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Currency $currency)
    {
        $this->em->flush($currency);
    }

    /**
     * @param Currency $currency
     * @return Currency
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Currency $currency)
    {
        $this->em->remove($currency);
        $this->em->flush($currency);

        return $currency;
    }

    /**
     * @param int $id
     * @return Currency
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeById($id)
    {
        return $this->remove($this->get($id));
    }
}