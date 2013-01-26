<?php
namespace WebBook\Controller;
use Core;

/**
 * This controller handles all of the book specific actions.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.4
 * @since     22/10/2012
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
		$this->view->addVariable('book', Core\StoreRequest::get('book'));
		$this->view->addVariable('user', Core\StoreRequest::get('user'));
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
		// Set to readonly
		$this->view->addVariable['readonly'] = true;

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
		// Set to readonly
		$this->view->addVariable['readonly'] = false;

		$this->forward('book');
	}

	/**
	 * Output the complete book.
	 *
	 * This action can be called via ajax or it can be forwarded to, it is
	 * generally never called directly.
	 *
	 * If it is called via Ajax then we do not want to use a layout.
	 *
	 * @access public
	 * @ajax
	 */
	public function bookAction() {
		if (Core\Request::isAjax()) {
			$this->setLayout(false);
		}
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