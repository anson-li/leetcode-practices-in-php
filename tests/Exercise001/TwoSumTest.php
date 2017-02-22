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
}
