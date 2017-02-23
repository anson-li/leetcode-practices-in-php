<?php

namespace Edentsai\LeetCode\Exercise001;

use InvalidArgumentException;

class MultipleSum
{
    /**
     * To solve multiple sum with specific amount.
     *
     * @param  int   $amount
     * @param  int   $target
     * @param  arary $numbers
     * @return array
     *
     * @throws \InvalidArgumentException When no solution.
     */
    public function solve(int $amount, int $target, array $numbers) : array
    {
        if (1 === $amount) {
            return $this->oneSum($target, $numbers);
        }

        throw new \InvalidArgumentException('No solution');
    }

    /**
     * To solve one sum.
     *
     * @param  int $target
     * @param  array $numbers
     * @return array
     *
     * @throws \InvalidArgumentException When No solution.
     */
    protected function oneSum(int $target, array $numbers) : array
    {
        foreach ($numbers as $index => $number) {
            if ($target === $number) {
                return [$index];
            }
        }

        throw new \InvalidArgumentException('No solution.');
    }
}
