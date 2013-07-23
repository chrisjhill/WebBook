<?php
namespace WebBook\Utility;
use Core;

/**
 * A single point of access for all URL's on the site.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Url
{
	/**
	 * Format a string for a URL.
	 *
	 * It is a three step process:
	 *
	 * <ol>
	 *     <li>Convert the string to lowercase</li>
	 *     <li>Replace all spaces with dashes</li>
	 *     <li>Remove all non alpha-numerical characters</li>
	 * </ol>
	 *
	 * This will convert <code>Title: Foobar</code> to <code>title-foobar</code>.
	 *
	 * @access public
	 * @param  string $string The string that we want to encode.
	 * @return string
	 * @static
	 */
	public static function encode($string) {
		return preg_replace(
			'/[^\w-]/',
			'',
			str_replace(
				' ',
				'-',
				strtolower($string)
			)
		);
	}

	/**
	 * Generates the address to edit a book.
	 *
	 * @access public
	 * @param  Model\Book\Instance $book The book to generate a URL for.
	 * @return string
	 * @static
	 */
	public static function bookEdit($book) {
		return Core\Config::get('path', 'root')
			. 'book/edit/id/'
			. $book->book_id
			. '/title/'
			. self::encode($book->book_title);

	}

	/**
	 * Generates the address to view a book.
	 *
	 * @access public
	 * @param  Model\Book\Instance $book The book to generate a URL for.
	 * @return string
	 * @static
	 */
	public static function bookView($book) {
		return Core\Config::get('path', 'root')
			. 'book/view/id/'
			. $book->book_id
			. '/title/'
			. self::encode($book->book_title);
	}

	/**
	 * Generates the address to view a book by its snapshot.
	 *
	 * @access public
	 * @param  Model\Book\Instance $book       The book to generate a URL for.
	 * @param  int                 $snapshotId The snapshot ID.
	 * @return string
	 * @static
	 */
	public static function bookViewSnapshot($book, $snapshotId) {
		return Core\Config::get('path', 'root')
			. 'book/view/id/'
			. $book->book_id
			. '/snapshot/'
			. $snapshotId
			. '/title/'
			. self::encode($book->book_title);
	}
}