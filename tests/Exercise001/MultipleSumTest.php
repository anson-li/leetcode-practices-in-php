<?php

namespace Edentsai\LeetCode\Tests\Exercise001;

use Edentsai\LeetCode\Tests\TestCase;
use Edentsai\LeetCode\Exercise001\MultipleSum;

class MultipleSumTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMultipleSumShouldThrowInvalidArgumentExceptionWhenNumbersAreEmpty()
    {
        $amount = 999;
        $target = 999;
        $numbers = [];

        $multipleSum = new MultipleSum();
        $actual = $multipleSum->solve($amount, $target, $numbers);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testOneSumShouldThrowInvalidArgumentExceptionWhenCannotBeSolved()
    {
        $amount = 999;
        $target = 999;
        $numbers = [1, 2, 3];

        $multipleSum = new MultipleSum();
        $actual = $multipleSum->solve($amount, $target, $numbers);
    }
}
