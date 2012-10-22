<?php
/**
 * Database information.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Model_Database
{
    /**
     * The database connection.
     *
     * @var array
     */
    private $_pdo;

    /**
     * Model_Database class instance.
     *
     * @var Model_Database
     * @static
     */
    private static $_classInstance;

    /**
     * Do nothing
     */
    public function __construct() {
        // Try and connect to the database
        try {
            // Connection
            $this->_pdo = new PDO(
                'mysql:host=localhost;dbname=webbook;charset=utf8',
                'root',
                'root'
            );
            
            // Return associative arrays by default
            $this->_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        } catch(PDOException $e) {
            // Uh-oh, something went wrong
            die($e->getMessage());
        }
    }
    
    /**
     * Get the database connection.
     *
     * @return PDO
     */
    public function getPdoConnection() {
        // Have we already created the instance?
        if (is_null(self::$_classInstance)) {
            self::$_classInstance = new Model_Database();
        }
        
        // And return
        return self::$_classInstance->_pdo;
    }
}