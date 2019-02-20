<?php
/**
 * Created by PhpStorm.
 * User: zhanglingyu
 * Date: 2019-02-18
 * Time: 12:56
 */

namespace ArcherZdip\GenerateIDNumber;


class Foo
{
    /** @var array $items */
    public $items;

    public function __construct($item = [])
    {
        $this->items = $item;
    }

    /**
     * to string
     *
     * @return array
     */
    public function toString()
    {
        return array_map(function ($value) {
            return is_object($value) ? $value->toString() : $value;
        }, $this->items);
    }

    /**
     * object -> array
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            return is_object($value) ? $value->toArray() : $value;
        }, $this->items);
    }

}