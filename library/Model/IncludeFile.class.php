<?php
/**
 * Simply includes a file.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

abstract class Model_IncludeFile
{
    /**
	 * Locate the file and include it
	 *
	 * @param string $file
	 * @throws Application_Exception_IncludeFile
	 */
    public static function load($file) {
        // Does the file exist?
        if (!include $_SERVER['DOCUMENT_ROOT'] . '/library/' . str_replace('_', '/', $file) . '.class.php') {
            throw new Exception(
                'could not find the correct file for ' . $file .
                '. The technical error is: 001x1x' . date('mdyGi', time())
            );
        }
    }
}