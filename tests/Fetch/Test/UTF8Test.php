<?php

namespace Fetch\Test;

use Fetch\UTF8;

/**
 * @package Fetch
 * @author  Robert Hafner <tedivm@tedivm.com>
 * @author  Sergey Linnik <linniksa@gmail.com>
 */
class UTF8Test extends \PHPUnit_Framework_TestCase
{
    public function dataFix()
    {
        return array(
            array(
                'ab11 ? ?????.jpg',
                "\x61\x62\x31\x31\x20\x97\x20\x3f\x3f\x3f\x3f\x3f\x2e\x6a\x70\x67",
            ),
            array(
                ' ??????????????',
                base64_decode('IKytrKastKyhrMCsu6yq'),
            )
        );
    }

    /**
     * @dataProvider dataFix
     *
     * @param string $expected
     * @param string $text
     * @param string $charset
     */
    public function testFix($expected, $text)
    {
        self::assertSame($expected, UTF8::fix($text));
    }
}
