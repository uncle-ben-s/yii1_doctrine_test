<?php


namespace shop\repositories\doctrine\types\Card;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use shop\entities\Card\Status;

class StatusType extends StringType
{
    const NAME = 'card_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getStatusName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Status($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}