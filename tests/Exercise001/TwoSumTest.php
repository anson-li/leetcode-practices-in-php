<?php

namespace Edentsai\LeetCode\Tests\Exercise001;

use Edentsai\LeetCode\Exercise001\TwoSum;
use Edentsai\LeetCode\Tests\TestCase;

class TwoSumTest extends TestCase
{
    public function notEnoughNumbersDataProvider() : array
    {
        return [
            'numbers are empty' => [
                'numbers' => [],
            ],
            'Just one number' => [
                'numbers' => [1],
            ],
        ];
    }

    /**
     * @dataProvider notEnoughNumbersDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function testTwoSumShouldThorwInvalidArgumentExceptionWhenAmountOfNumbersNotEnough(array $numbers)
    {
        $twoSum = new TwoSum();

        $target = 1;

        $twoSum->solve($target, $numbers);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTwoSumShouldThrowInvalidArgumentExceptionWhenCannotBeSolved()
    {
        $twoSum = new TwoSum();

        $target = 1;
        $numbers = [2, 3];

        $twoSum->solve($target, $numbers);
    }

    public function parametersDataProvider() : array
    {
        return [
            [
                'target' => 9,
                'numbers' => [2, 7, 11, 15],
                'expected' => [0, 1],
            ],
            [
                'target' => 9,
                'numbers' => [15, 11, 7, 2],
                'expected' => [2, 3],
            ],
            [
                'target' => 9,
                'numbers' => [11, 2, 7, 15],
                'expected' => [1, 2],
            ],
        ];
    }

    /**
     * @dataProvider parametersDataProvider
     */
    public function testTwoSumShouldReturnArrayWithAnswerWhenSolved(int $target, array $numbers, array $expected)
    {
        $twoSum = new TwoSum();

        $this->assertSame(
            $expected,
            $twoSum->solve($target, $numbers)
        );
    }
}
