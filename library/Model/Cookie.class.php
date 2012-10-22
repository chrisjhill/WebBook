<?php
/**
 * Handles creating, fetching and remove cookies from the client.
 * 
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */
 
class Model_Cookie
{
    /**
     * Sets a cookie via preset parameters.
     *
     * $expires is the number of days.
     *
     * @static
     * @param string $name
     * @param string $value
     * @param integer $expires
     */
    public static function newCookie($name, $value, $expires) {
        setcookie($name, $value, time() + ($expires * (3600 * 24)), "/", ".getesignature.co.uk", 1);
    }

    /**
     * Returns a cookie through the name
     *
     * @static
     * @param string $name
     */
    public static function getCookie($name) {
        return isset($_COOKIE[$name])
            ? $_COOKIE[$name]
            : '';
    }

    /**
     * Deletes the cookie.
     *
     * @static
     * @param string $name
     */
    public static function deleteCookie($name) {
        setcookie($name, '', (time() - 3600), "/", ".getesignature.co.uk", 1);
    }
}