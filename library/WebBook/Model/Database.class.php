<?php
namespace WebBook\Model;

/**
 * Database information.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.2
 * @since     22/10/2012
 */
class Database
{
	/**
	 * The database connection.
	 *
	 * This is private to force the user of the get() function to
	 * ensure we always have a database connection.
	 *
	 * @access private
	 * @var	   \PDO
	 * @static
	 */
	private static $_pdo;

	/**
	 * Return a database connection.
	 *
	 * @access public
	 * @return \PDO   The database connection.
	 * @static
	 */
	public static function get() {
		// Have we already established a connection?
		if (! self::$_pdo) {
			self::establishConnection();
		}

		return self::$_pdo;
	}

	/**
	 * Try and establish a connection to the database.
	 *
	 * @access public
	 */
	public function establishConnection() {
		// Try and connect to the database
		try {
			// Connection
			self::$_pdo = new \PDO(
				'mysql:host=localhost;dbname=webbook;charset=utf8',
				'root',
				'root'
			);

			// Return associative arrays by default
			self::$_pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
			self::$_pdo->setAttribute(\PDO::ATTR_ERRMODE,			\PDO::ERRMODE_WARNING);

		} catch(\PDOException $e) {
			// Uh-oh, something went wrong
			// @todo Handle database errors more gracefully
			die($e->getMessage());
		}
	}
}