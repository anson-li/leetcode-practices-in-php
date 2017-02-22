<?php
namespace Edentsai\LeetCode\Exercise001;

use InvalidArgumentException;

/**
 * Two Sum
 *
 * Given an array of integers, return indices of the two numbers such that they add up to a specific target.
 * You may assume that each input would have exactly one solution, and you may not use the same element twice.
 */
class TwoSum
{
    /**
     * To solve the two sum question.
     *
     * @param  int   $target
     * @param  array $numbers
     * @return array
     *
     * @throws \InvalidArgumentException When no solution.
     */
    public function solve(int $target, array $numbers) : array
    {
        throw new InvalidArgumentException('No two sum solution.');
    }
}
