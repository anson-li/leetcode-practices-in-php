<?php

namespace Ansonli\LeetCode\Exercise004;

class RomanInteger {

	public function solve(int $integer) : string
	{
		$romanValues = [1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD', 100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL', 10 => 'X', 5 => 'V', 4 => 'IV', 1 => 'I'];
		$string = '';
		foreach ($romanValues as $key => $value) {
			for ($i = 4; $i > 0; $i--) {
				if ($integer >= ($key * $i)) {
					$integer =- ($key * $i);
					while ($i > 0) {
						$string .= $value;
						$i--;
					}
				}
			}
		}
		return $string;
	}

}

