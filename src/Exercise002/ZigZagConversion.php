<?php

namespace Ansonli\LeetCode\Exercise002;

/**
 * The string "PAYPALISHIRING" is written in a zigzag pattern on a given number of rows like this: (you may want to display this pattern in a fixed font for better legibility)
 * P   A   H   N
 * A P L S I I G
 * Y   I   R
 * And then read line by line: "PAHNAPLSIIGYIR"
 */

class ZigZagConversion 
{
	public function convert(string $string, int $rows) : string
	{
		$row_iteration = 0;
		$column_iteration = 0;
		$desc = TRUE;
		$string_array = str_split($string);
		$string_grid = [];
		$solution = '';
		foreach ($string_array as $character) 
		{ 
			$string_grid[] = ['value' => $character, 'x' => $column_iteration, 'y' => $row_iteration];
			if ($row_iteration === $rows - 1) 
			{
				// Row iteration has hit its peak
				$desc = FALSE;
				$column_iteration++;
				$row_iteration--;
			} 
			elseif ($desc === FALSE) 
			{
				// Row iteration is decreasing (ascending)
				$column_iteration++;
				$row_iteration--;
				if ($row_iteration === 0) 
				{
					$desc = TRUE;
				}
			}
			else 
			{
				$row_iteration++;
			}
		}
		array_multisort(array_column($string_grid, 'y'), SORT_ASC, array_column($string_grid, 'x'), SORT_ASC, $string_grid);
		foreach ($string_grid as $value) 
		{
			$solution .= $value['value'];
		}
		return $solution;
	}
}