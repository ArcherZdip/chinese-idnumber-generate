<?php
/**
 * Created by PhpStorm.
 * User: zhanglingyu
 * Date: 2019-02-18
 * Time: 10:55
 */

namespace ArcherZdip\GenerateIDNumber;


class ChineseIDNumber
{

    /** @var $id */
    public $id;

    /** @var $province */
    public $province;

    /** @var $city */
    public $city;

    /** @var $region */
    public $region;

    /** @var $sex */
    public $sex;

    /** @var $birth */
    public $birth;

    public function __construct()
    {
        
    }

    /**
     * @return mixed
     */
    public function toString()
    {
        return $this->id;
    }

    /**
     * @return array|mixed|object
     */
    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}