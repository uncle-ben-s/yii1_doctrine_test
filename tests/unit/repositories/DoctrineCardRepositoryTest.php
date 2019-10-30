<?php


namespace tests\unit\repositories;

use ProxyManager\Factory\AccessInterceptorValueHolderFactory;
use shop\entities\Card\Card;
use shop\repositories\DoctrineCardRepository;

class DoctrineCardRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before()
    {
        $em = $this->getModule('Doctrine2')->em;

        $repository = new DoctrineCardRepository($em, $em->getRepository(Card::class));

        $this->repository = (new AccessInterceptorValueHolderFactory())->createProxy($repository, [
            'get' => function () use ($em) { $em->clear(); },
        ]);
    }
}