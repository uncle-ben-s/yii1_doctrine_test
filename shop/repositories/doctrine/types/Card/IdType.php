<?php


namespace shop\repositories\doctrine\types\Card;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use shop\entities\Card\Id;

class IdType extends GuidType
{
    const NAME = 'card_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var Id $value */
        return $value->getId();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Id($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}