<?php
namespace WebBook\Utility;
use Core;

/**
 * Decides if a user (logged in or not) can edit or view a book.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Permission
{
	/**
	 * Discover if a user can or cannot view a book.
	 *
	 * @access public
	 * @param  Model\Book\Instance $book The book the user has navigated to.
	 * @param  Model\User\Instance $user The user instance.
	 * @return boolean
	 * @static
	 */
	public static function canView($book = null, $user = null) {
		// If we have not been supplied the data, then gather from store
		if (! $book) { $book = Core\Store\Request::get('book'); }
		if (! $user) { $user = Core\Store\Request::get('user'); }

		// We do not necessarily need require a user to be logged in, because
		// .. the author could have freely distributed the book (i.e., not private).
		// We do, however, need to make sure there is a book to read
		if (! $book->has('book_id')) {
			return false;
		}

		// There is a book, but can we read it?
		else if ($book->book_distribution == 0) {
			// Book is private, only the author can read it
			// Make sure a user is logged in, and that they are the author
			if (! $user->has('user_id') || $user->user_id != $book->user_id) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Discover if a user can or cannot edit a book.
	 *
	 * @access public
	 * @param  Model\Book\Instance $book The book the user has navigated to.
	 * @param  Model\User\Instance $user The user instance.
	 * @return boolean
	 * @static
	 */
	public static function canEdit($book = null, $user = null) {
		// If we have not been supplied the data, then gather from store
		if (! $book) { $book = Core\Store\Request::get('book'); }
		if (! $user) { $user = Core\Store\Request::get('user'); }

		// To edit a book you must be logged in, and there must be a book!
		if (! $user->has('user_id') || ! $book->has('book_id')) {
			return false;
		}

		// User is logged in, but is it the author?
		else if ($user->user_id != $book->user_id) {
			return false;
		}

		return true;
	}
}