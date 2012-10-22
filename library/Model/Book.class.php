<?php
/**
 * Contains information on the book.
 * 
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Model_Book
{
    /**
     * Information on the book.
     *
     * @var array
     */
    private $_info = array();
    
    /**
     * Model_Book class instance.
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
     * Get an instance of the book.
     *
     * @param int $bookId
     * @param int $userId
     * @param string $bookPassword
     * @return Model_Book
     */
    public function getInstance($bookId, $userId, $bookPassword) {
        // Have we already created the instance?
        if (is_null(self::$_classInstance)) {
            // Create instance
            self::$_classInstance = new Model_Book();
            
            // Set information
            self::$_classInstance->setInfo($bookId, $userId, $bookPassword);

        }
        
        // And return
        return self::$_classInstance;
    }

    /**
     * Set all of the user information.
     *
     * @param int $bookId
     * @param int $userId
     * @param string $bookPassword
     * @param array $param
     */
    public function setInfo($bookId, $userId, $bookPassword) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Do we need to find the book for a user?
        $query = $userId >= 1
            ? $this->setInfoLoggedIn($pdo, $bookId, $userId)
            : $this->setInfoRead($pdo, $bookId);
        
        // Could we the book?
        if ($query->rowCount() <= 0) {
            // Not found
            die('Oops. I do not think this is your book!');
        }
        
        // Set all of the information
        $this->_info = $query->fetch();
        
        // A book distribution password has been supplied
        if ($bookPassword != '') {
            // Is the book available for free distribution?
            if ($this->getInfo('book_distribution') == '0') {
                die('You supplied a password, but the book is set to private!');
            }
            
            // Is this the right password?
            if ($bookPassword != $this->getPassword()) {
                die('Wrong password, matey-jim.');
            }
        }
    }
    
    /**
     * Get the book for a logged in user.
     * 
     * @param PDO $pdo
     * @param int $bookId
     * @param int $userId
     */
    public function setInfoLoggedIn($pdo, $bookId, $userId) {
        // Set query string
        $query = $pdo->prepare("
            SELECT b.book_id, b.user_id, b.book_title, b.book_distribution, b.book_created, b.book_updated, b.book_removed,
                   (
                       SELECT SUM(s.section_word_count)
                       FROM   `section` s
                       WHERE  s.book_id         = :book_id
                              AND
                              s.section_removed = 0
                   ) as 'book_word_count'
            FROM   `book` b
            WHERE  b.book_id = :book_id
                   AND
                   b.user_id = :user_id
            LIMIT  1
        ");
        
        // And execute
        $query->execute(array(
            ':book_id' => $bookId,
            ':user_id' => $userId
        ));
        
        // Return
        return $query;
    }
    
    /**
     * Get the book for someone just reading the book.
     * 
     * @param PDO $pdo
     * @param int $bookId
     */
    public function setInfoRead($pdo, $bookId) {
        // Set query string
        $query = $pdo->prepare("
            SELECT b.book_id, b.user_id, b.book_title, b.book_distribution, b.book_created, b.book_updated, b.book_removed
            FROM   `book` b
            WHERE  b.book_id = :book_id
            LIMIT  1
        ");
        
        // And execute
        $query->execute(array(
            ':book_id' => $bookId
        ));
        
        // Return
        return $query;
    }

    /**
     * Returns a piece of information on the book.
     *
     * @return mixed
     */
    public function getInfo($index) {
        return isset($this->_info[$index])
            ? $this->_info[$index]
            : '';
    }
    
    /**
     * Get the book password.
     * 
     * @return string
     */
    public function getPassword() {
        return substr(
            md5($this->getInfo('book_id') . $this->getInfo('book_created')),
            0, 8
        );
    }
}