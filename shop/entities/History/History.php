<?php


namespace shop\entities\History;


use shop\entities\Card\Card;
use shop\entities\User\User;

class History
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var Card
     */
    private $card;
    /**
     * @var User
     */
    private $user;
    /**
     * @var \DateTime
     */
    private $createDate;
    /**
     * @var Type
     */
    private $type;
    /**
     * @var string
     */
    private $info;

    /**
     * History constructor.
     * @param Card $card
     * @param Type $type
     * @param User $user
     * @param \DateTime $date
     * @param string $info
     */
    public function __construct(Card $card, Type $type, User $user, \DateTime $date, $info){
        $this->card = $card;
        $this->user = $user;
        $this->type = $type;
        $this->createDate = $date;
        $this->info = $info;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return Card
     */
    public function getCard(){
        return $this->card;
    }

    /**
     * @return User
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate(){
        return $this->createDate;
    }

    /**
     * @return Type
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @return string
     */
    public function getInfo(){
        return $this->info;
    }
}