<?php
/**
 * Returns random strings.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

abstract class Model_RandomString
{
    /**
     * Generates and returns a random string
     *
     * @param integer $length
     * @return string
     */
    public static function generate($length = 8) {
        $string = null;
        $length--;
        $characters = "_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";

        while (strlen($string) <= $length) {
            $string .= $characters[mt_rand(0,62)];
        }

        return $string;
    }
}