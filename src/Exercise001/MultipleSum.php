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
        if ($amount > 1) {
            $remain['amount'] = $amount - 1;
            foreach ($numbers as $index => $number) {
                $remain['target'] = $target - $number;
                $remain['numbers'] = $numbers;
                unset($remain['numbers'][$index]);
                try {
                    return array_merge(
                        [$index],
                        $this->solve($remain['amount'], $remain['target'], $remain['numbers'])
                    );
                } catch (InvalidArgumentException $exception) {
                    continue;
                }
            }
        } elseif (1 === $amount) {
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
