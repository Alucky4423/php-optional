<?php

use PHPUnit\Framework\TestCase;

use Alucky4423\Optional;
use Alucky4423\Exceptions\NullPointerException;

class OptionalTest extends TestCase
{
//    public function setUp()
//    {
//        //
//    }


    public function testOf()
    {
        $actual = Optional::of('value');
        $this->assertInstanceOf(Optional::class, $actual);
    }


    public function testOfThrowException()
    {
        $this->expectException(NullPointerException::class);
        Optional::of(null);
    }


    public function ofNullableDataProvider()
    {
        return [
            'null' => [null],
            'string' => ['string'],
            'int' => [1],
            'object' => [new stdClass()]
        ];
    }

    /**
     * @param $value
     * @dataProvider ofNullableDataProvider
     */
    public function testOfNullable($value)
    {
        $actual = Optional::ofNullable($value);
        $this->assertInstanceOf(Optional::class, $actual);
    }


    public function testIsPresent()
    {
        $optional = Optional::of("test");
        $this->assertTrue($optional->isPresent());
        $optional = Optional::ofNullable(null);
        $this->assertFalse($optional->isPresent());
    }


    public function testIfPresent01()
    {
        Optional::of("test")->ifPresent(function($value) {
            $this->assertTrue(true);
        });
    }

    public function testIfPresent02()
    {
        $this->expectException(TypeError::class);
        Optional::ofNullable("test")->ifPresent(null);
    }

    public function toStringDataProvider()
    {
        return [
            'value of null.' => [null, 'Optional<NULL>'],
            'value of string.' => ['string', 'Optional<string>'],
        ];
    }

    /**
     * @param $value
     * @dataProvider toStringDataProvider
     */
    public function testToString($value, $expected)
    {
        $optional = Optional::ofNullable($value);
        $this->assertEquals($expected, $optional->__toString(), $optional->__toString());
    }
}
