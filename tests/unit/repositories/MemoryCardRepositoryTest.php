<?php


namespace tests\unit\repositories;


use shop\repositories\MemoryCardRepository;

class MemoryCardRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before()
    {
        $this->repository = new MemoryCardRepository();
    }
}