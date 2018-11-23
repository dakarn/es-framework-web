<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 11:47
 */

use PHPUnit\Framework\TestCase;

class HelloTest extends TestCase
{
    public function testCalc()
    {
        $this->assertEquals('1', '1');
    }
}