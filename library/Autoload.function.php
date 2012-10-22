<?php
/**
 * Makes sure the included class exists, if not throw an error.
 * 
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

include $_SERVER['DOCUMENT_ROOT'] . '/library/Model/IncludeFile.class.php';

/**
 * Attempt to load a class that is missing
 *
 * @param string $file
 */
function __autoload($file) {
    try {
        Model_IncludeFile::load($file);
    } catch (Exception $e) {
        echo new Model_Notice('error', Array($e->__toString()));
        die();
    }
}