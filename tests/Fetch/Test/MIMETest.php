<?php

/*
 * This file is part of the Fetch library.
 *
 * (c) Robert Hafner <tedivm@tedivm.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fetch\Test;

use Fetch\MIME;

/**
 * @package Fetch
 * @author  Robert Hafner <tedivm@tedivm.com>
 * @author  Sergey Linnik <linniksa@gmail.com>
 */
class MIMETest extends \PHPUnit_Framework_TestCase
{
    public function decodeData()
    {
        return array(
            array(null, null),
            array('Just text', 'Just text'),
            array('Keith Moore <moore@cs.utk.edu>', '=?US-ASCII?Q?Keith_Moore?= <moore@cs.utk.edu>'),
            array('Keld Jørn Simonsen <keld@dkuug.dk>', '=?ISO-8859-1?Q?Keld_J=F8rn_Simonsen?= <keld@dkuug.dk>'),
            array('André Pirard <PIRARD@vm1.ulg.ac.be>', '=?ISO-8859-1?Q?Andr=E9?= Pirard <PIRARD@vm1.ulg.ac.be>'),
            array(
                'If you can read this you understand the example.',
                '=?ISO-8859-1?B?SWYgeW91IGNhbiByZWFkIHRoaXMgeW8=?='
                . PHP_EOL .
                '=?ISO-8859-2?B?dSB1bmRlcnN0YW5kIHRoZSBleGFtcGxlLg==?='
            ),
            array(
                'ab11 ? ?????.jpg',
                "\x61\x62\x31\x31\x20\x97\x20\x3f\x3f\x3f\x3f\x3f\x2e\x6a\x70\x67",
            ),
            array(
                '?????? ?????.pdf',
                '=?UTF-8?B?' .base64_encode("\xCF\xF0\xE8\xEC\xE5\xF0 \xEF\xEB\xE0\xED\xE0\x2E\x70\x64\x66") . '?=',
            ),
            array(
                ' (ИСТРЕБИТЕЛЬ ЛЕТАЮЩИХ НАСЕКОМЫХ "БАРГУЗИН" КП ДИЛЕР - 2019г)',
                ' =?ks_c_5601-1987?B?ICisqqyzrLSssqymrKKsqqy0rKasray+IKytrKastKyhrMCsu6yq?=' .
                ' =?ks_c_5601-1987?B?rLcgrK+soayzrKasrKywrK6svay3ICKsoqyhrLKspKy1?=' .
                ' =?ks_c_5601-1987?B?rKmsqqyvIiCsrKyxIKylrKqsraymrLIgLSAyMDE5rNQp?=',
            ),
        );
    }

    /**
     * @dataProvider decodeData
     *
     * @param string $expected
     * @param string $text
     * @param string $charset
     */
    public function testDecode($expected, $text, $charset = 'UTF-8')
    {
        self::assertSame($expected, MIME::decode($text, $charset));
    }
}
