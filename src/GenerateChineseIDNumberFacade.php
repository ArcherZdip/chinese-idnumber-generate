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
        return 'generate_ch_id';
    }

}