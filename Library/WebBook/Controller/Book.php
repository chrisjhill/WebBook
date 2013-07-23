<?php
namespace WebBook\Controller;
use Core, WebBook\Utility;

/**
 * This controller handles all of the book specific actions.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Book extends Core\Controller
{
	/**
	 * This function is called on each load on this controller.
	 *
	 * It's job is to provide a consistent environment for the rest of the actions.
	 *
	 * @access public
	 */
	public function init() {
		// If there is no book then redirect
		if (! Core\Store\Request::get('book')->has('book_id')) {
			$this->forward('index', 'index');
		}

		// The book exists
		$this->setLayout('book');
		$this->view->addVariable('book', Core\Store\Request::get('book'));
		$this->view->addVariable('user', Core\Store\Request::get('user'));
	}

	/**
	 * Allow a book to be viewed in readonly mode.
	 *
	 * This action is called when a user views a book which they do not have
	 * access to edit, or if the owner of the book passes a URL to a friend.
	 *
	 * @access public
	 */
	public function viewAction() {
		// Can the user read this book?
		if (! Utility\Permission::canView()) {
			$this->forward('index', 'index');
		}

		// Set to readonly and forward onto the book
		$this->view->addVariable('readonly', true);
		$this->setLayout('readonly');
		$this->forward('book');
	}

	/**
	 * Allowing a book to be edited by the user.
	 *
	 * This is the action that is called when a user requests to edit a book.
	 * Note that this action does not actually load the book, instead it
	 * forwards onto the
	 *
	 * @access public
	 */
	public function editAction() {
		// Can the user edit this book?
		if (! Utility\Permission::canEdit()) {
			// Nope, but they still might be able to view it
			$this->forward('view');
		}

		// Set to readonly
		$this->view->addVariable('readonly', false);
		$this->forward('book');
	}

	/**
	 * Output the complete book.
	 *
	 * @access public
	 */
	public function bookAction() {
		// Do nothing
	}

	/**
	 * The error action.
	 *
	 * @access public
	 */
	public function errorAction() {
		// Do nothing
	}
}