<?php
/**
 * Created by PhpStorm.
 * User: zhanglingyu
 * Date: 2019-02-16
 * Time: 07:47
 */
namespace ArcherZdip\Test\GenerateChineseIDNumber;

use ArcherZdip\GenerateIDNumber\ChineseIDNumber;
use ArcherZdip\GenerateIDNumber\GenerateChineseIDNumberService;
use Tests\TestCase;

class GenerateChineseIDNumberServiceTest extends TestCase
{
    /**
     * @test
     *
     */
    public function testGet()
    {
        $g = new GenerateChineseIDNumberService();

        $res = $g->on([

        ])->limit(2)->get()->toString();

        dd($res);
    }

    /**
     * @test
     *
     */
    public function testGetOne()
    {
        $g = new GenerateChineseIDNumberService();

        $res = $g->on([
            'info' => 1,
            'province' => '辽宁省',
            'city1' => '朝阳市',
            'datetime' => '2018-02-12',
            'info' => 1
        ])->getOne()->toArray();

        dd($res);
    }
}