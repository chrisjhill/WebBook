<?php
/**
 * The formatting class, how things should be formatted.
 * 
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Model_Format
{
    /**
     * Return a safe HTML string
     *
     * @param string $input
     * @return string
     */
    public static function parseHtml($input) {
        return htmlentities($input, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Return a number that looks nice
     *
     * Note: Do not use this to place numbers into a database, store raw numbers only.
     *
     * @param string $input
     * @return string
     */
    public static function parseNumber($input, $precision = 2, $decimalPoint = '.', $thousandsSeparator = ',') {
        return number_format($input, $precision, $decimalPoint, $thousandsSeparator);
    }

    /**
     * Strips all invalid characters out of the string and returns.
     *
     * @param string $input
     * @return string
     */
    public function parseUrl($input) {
        return
            preg_replace(
                "/[^a-z0-9-]/",
                "",
                strtolower(
                    str_replace(' ', '-', $input)
                )
            );
    }
}