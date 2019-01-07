<?php

/**
 * represents a United States Zip code
 *
 * Web API for validation?
 * https://tools.usps.com/go/ZipLookupResultsAction!input.action?resultMode=2&companyName=&address1=&address2=&city=&state=Select&urbanCode=&postalCode=90210-3116&zip=
 * https://en.wikipedia.org/wiki/List_of_ZIP_code_prefixes
 *
 * State from first three digits of Zip code table
 * http://pe.usps.gov/Archive/HTML/DMMArchive0106/L002.htm
 *
 * Info about Zip Codes
 * http://mcdc.missouri.edu/allabout/zipcodes.html
 *
 * Free Zip Code database CSV format
 * http://federalgovernmentzipcodes.us/
 *
 */
class USAZipCode
{

    /**
     * attempt to coax $zipCode into a valid format and returns a valid 5 digit
     * zip code or a valid 9 digit code with a hyphen between the segments
     * (10 digits in total); or false on error
     *
     * @param string $zipCode
     *
     * @return string|false
     * @throws Exception
     */
    public function normalizeAndValidate($zipCode)
    {
        if(is_string($zipCode) === false)
        {
            return false;
        }
        $zipCode = $this->getCleaned($zipCode);
        $zipCode = $this->getNormalized($zipCode);

        $validator = new USAZipCodeValidator();
        if($validator->validateFormat($zipCode) === true)
        {
            return $zipCode;
        }

        return false;
    }

    /**
     * returns a cleaned up zip code
     *
     * @param string $zipCode
     *
     * @return string
     */
    private function getCleaned($zipCode): string
    {
        // trim
        $zipCode = trim($zipCode);

        // remove hyphens
        $zipCode = str_replace('-', '', $zipCode);

        // remove spaces
        $zipCode = preg_replace('/\s+/', '', $zipCode);

        // it's a common mistake to use the letter 'o' instead
        // of the number zero. Since a letter 'o' is never in a valid zip
        // code, we can safely replace it with zero
        $zipCode = strtoupper($zipCode);
        $zipCode = str_replace('O', '0', $zipCode);
        return $zipCode;
    }

    /**
     * returns 5 digit zip code or a 9 digit code with a hyphen between the segments or
     * an empty string on error
     *
     * example: 90210 -> 90210
     * example: 902103116 -> 90210-3116
     *
     * @param string $zipCode
     *
     * @return string
     */
    private function getNormalized($zipCode): string
    {
        $zipCodeLength = strlen($zipCode);
        if($zipCodeLength === 5)
        {
            return $zipCode;
        }

        if($zipCodeLength === 9)
        {
            return substr($zipCode, 0, 5).'-'.substr($zipCode, 5);
        }
        return '';
    }
}