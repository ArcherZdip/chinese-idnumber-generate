<?php
/**
 * Created by PhpStorm.
 * User: zhanglingyu
 * Date: 2019-02-20
 * Time: 11:05
 */

namespace ArcherZdip\Test\GenerateChineseIDNumber;


use Tests\TestCase;
use ArcherZdip\GenerateIDNumber\VerityChineseIDNumber;

class VerityChineseIDNumberTest extends TestCase
{

    /**
     * @test
     *
     */
    public function test_isValid()
    {
        $res = VerityChineseIDNumber::isValid('810000197407066216');

        $this->assertTrue($res);
    }

    /**
     * @test
     *
     */
    public function test_getBirthday()
    {
        $res = (new VerityChineseIDNumber('810000197407066216'))->getBirthday()->format('Y-m-d');

        $this->assertEquals('1974-07-06', $res);
    }

    /**
     * @test
     *
     */
    public function test_getAge()
    {
        $res = (new VerityChineseIDNumber('810000197407066216'))->getAge();

        $this->assertEquals(44, $res);
    }

    /**
     * @test
     *
     */
    public function test_isFemale()
    {
        $res = (new VerityChineseIDNumber('810000197407066216'))->isFemale();

        $this->assertFalse($res);
    }

}