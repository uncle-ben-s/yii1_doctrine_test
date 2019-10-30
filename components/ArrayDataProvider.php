<?php


namespace app\components;


use CArrayDataProvider;

class ArrayDataProvider extends CArrayDataProvider
{
    protected function fetchKeys(){
        if($this->keyField === false)
            return array_keys($this->rawData);

        $keys = array();
        foreach($this->getData() as $i => $data)
            $keys[$i] = is_object($data) ? $data->getId() : $data[$this->keyField];

        return $keys;
    }
}