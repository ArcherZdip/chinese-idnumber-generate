<?php
/**
 * Created by PhpStorm.
 * User: zhanglingyu
 * Date: 2019-02-16
 * Time: 07:47
 */
namespace ArcherZdip\Test\GenerateChineseIDNumber;

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
            'info' => 0
        ])->limit(5)->get();

        dd($res);
    }

    /**
     * @test
     *
     */
    public function testGetone()
    {
        $g = new GenerateChineseIDNumberService();

        $res = $g->on([
            'info' => 1,
            'province' => '辽宁省',
            'city1' => '朝阳市',
            'datetime' => '2018-02-12'
        ])->getone();

        dd($res);
    }
}