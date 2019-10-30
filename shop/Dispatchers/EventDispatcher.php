<?php


namespace shop\Dispatchers;


interface EventDispatcher
{
    public function dispatch(array $events);
}