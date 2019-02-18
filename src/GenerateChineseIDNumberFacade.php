<?php
/**
 * Created by PhpStorm.
 * User: zhanglingyu
 * Date: 2019-02-15
 * Time: 18:18
 */

namespace ArcherZdip\GenerateIDNumber;


class GenerateChineseIDNumberFacade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chinese_id_faker';
    }

}