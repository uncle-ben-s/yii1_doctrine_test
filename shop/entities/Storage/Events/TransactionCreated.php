<?php


namespace shop\entities\Storage\Events;


use shop\entities\Storage\Transaction;

class TransactionCreated
{

    /**
     * TransactionCreated constructor.
     * @param Transaction $param
     */
    public function __construct(Transaction $param){
    }
}