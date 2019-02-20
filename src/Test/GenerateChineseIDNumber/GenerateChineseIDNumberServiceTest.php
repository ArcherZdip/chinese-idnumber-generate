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

        $res = $g->on()->limit(2)->get()->toArray();

        dd($res);
    }

    /**
     * @test
     *
     */
    public function testGetOne()
    {
        $g = new GenerateChineseIDNumberService();

        $res = $g->province('辽宁省')->getOne()->toArray();

        dd($res);
    }
}