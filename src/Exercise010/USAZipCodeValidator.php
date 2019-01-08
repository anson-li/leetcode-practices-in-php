<?php

namespace Ansonli\LeetCode\Exercise010;

class USAZipCodeValidator
{
    /**
     * returns true if the format matches 90210 or 90210-3116; otherwise false is returned
     *
     * @param string $zipCode
     *
     * @return bool
     * @throws Exception
     */
    public function validateFormat($zipCode): bool
    {
        if(is_string($zipCode) === false)
        {
            return false;
        }
        $zipCode = strtoupper($zipCode);

        // makes sure $zipCode is of the correct format to be a United States Zip Code
        $pattern = '/^\d{5}(-\d{4})?$/';
        $result = preg_match($pattern, $zipCode);
        if($result === false)
        {
            throw new Exception('preg_match returned false');
        }
        return $result === 1;
    }
}