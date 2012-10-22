<?php
/**
 * Deals with any database errors.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Exception_Database extends Exception
{
    /**
     * Construct the exception error message
     *
     * @param string $message
     */
    public function __construct($message) {
        parent::__construct($message, 5);
    }

    /**
     * Return the error message
     *
     * @return string
     */
    public function __tostring() {
        return $this->getMessage();
    }
}