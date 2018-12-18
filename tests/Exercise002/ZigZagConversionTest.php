<?php

namespace Ansonli\LeetCode\Tests\Exercise002;

use Ansonli\LeetCode\Exercise002\ZigZagConversion;
use Ansonli\LeetCode\Tests\TestCase;

class ZigZagConversionTest extends TestCase
{

    public function parametersDataProvider() : array
    {
        return [
            [
                'string' => 'PAYPALISHIRING',
                'rows' => 3,
                'expected' => 'PAHNAPLSIIGYIR',
            ],
            [
                'string' => 'WHERETHEWILDTHINGSARE',
                'rows' => 4,
                'expected' => 'WHTAHTEDHSREEWLIGERIN',
            ],
            [
                'string' => 'FLYONTHEPACIFIC',
                'rows' => 5,
                'expected' => 'FPLEAYHCCOTIINF',
            ],
        ];
    }

    /**
     * @dataProvider parametersDataProvider
     */
    public function testZigZagConversion(string $string, int $rows, string $expected)
    {
        $zigZagConversion = new ZigZagConversion();
        $this->assertSame($expected, $zigZagConversion->convert($string, $rows));
    }
}
