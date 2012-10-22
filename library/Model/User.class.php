<?php
/**
 * Contains information on the user.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Model_User
{
    /**
     * Information on the user.
     *
     * @var array
     */
    private $_info = array();
    
    /**
     * Model_User class instance.
     *
     * @var Model_User
     * @static
     */
    private static $_classInstance;

    /**
     * Do nothing
     */
    public function __construct() { }
    
    /**
     * Get an instance of the user.
     *
     * @param int $userId
     * @return Model_User
     */
    public function getInstance($userId) {
        // Have we already created the instance?
        if (is_null(self::$_classInstance)) {
            // Create instance
            self::$_classInstance = new Model_User($userId);
            
            // Set information
            self::$_classInstance->setInfo($userId);

        }
        
        // And return
        return self::$_classInstance;
    }

    /**
     * Set all of the user information.
     *
     * @param int $userId
     * @param array $param
     */
    public function setInfo($userId) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            SELECT u.user_id, u.user_name, u.user_email, u.user_password, u.user_created, u.user_updated, u.user_removed,
                   p.plan_id, p.plan_title, p.plan_book_limit, p.plan_snapshot_limit
            FROM   `user` u
                       LEFT JOIN `plan` p ON p.plan_id = u.plan_id
            WHERE  u.user_id = :user_id
            LIMIT  1
        ");
        
        // And execute
        $query->execute(array(
            ':user_id' => $userId
        ));
        
        // Could we the user?
        if ($query->rowCount() <= 0) {
            // Could not find, redirect to login page
            die('I no find user :(');
        }
        
        // Set all of the information
        $this->_info = $query->fetch();
    }

    /**
     * Is the user logged into the system?
     *
     * @return boolean
     **/
    public function isUserLoggedIn() {
	   return isset($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])
	       ? true
	       : false;
    }

    /**
     * Returns a piece of information on the user.
     *
     * @return mixed
     */
    public function getInfo($index) {
        return isset($this->_info[$index])
            ? $this->_info[$index]
            : '';
    }
}