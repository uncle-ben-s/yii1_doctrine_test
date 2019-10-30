<?php


namespace shop\entities\Filter;


use shop\entities\AggregateRoot;
use shop\entities\EventTrait;
use Webmozart\Assert\Assert;

class Filter implements AggregateRoot
{
    use EventTrait;

    /**
     * @var int
     */
    private $id;
    /**
     * @var FilterType
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * Filter constructor.
     * @param FilterType $filterType
     * @param string $value
     */
    public function __construct(FilterType $filterType, $value){
        Assert::notEmpty($value);
        $this->value = $value;
        $this->changeFilterType($filterType);

        $this->recordEvent(new Events\FilterCreated($this));
    }


    /**
     * @param Filter $filter
     * @return bool
     */
    public function isEqualTo(Filter $filter){
        return $this->value === $filter->getValue() &&
            $this->type->getName() === $filter->getType()->getName();
    }

    /**
     * @param FilterType $filterType
     */
    public function changeFilterType($filterType){
        $this->type = $filterType;
    }

    /**
     * @param string $value
     */
    public function changeValue($value){
        $this->value = $value;

        $this->recordEvent(new Events\FilterChangeValue($this));
    }

    /**
     * @return FilterType
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }
}