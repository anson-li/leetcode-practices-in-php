<?php

namespace Ansonli\LeetCode\Exercise002;

/**
 * Given a string s, find the longest palindromic substring in s. You may assume that the maximum length of s is 1000.
 */

class LargestPalindrome {

	public function solve(string $string) {
		$longest = '';
		for ($i = 0; $i < strlen($string); $i++) {
			for ($j = 3; $j <= strlen($string); $j++) {
				$substr = substr($string, $i, $j);
				if (($substr === strrev($substr)) && (strlen($substr) > strlen($longest))) {
					$longest = $substr;
				}
			}
		}
		return $longest;
	}

}

