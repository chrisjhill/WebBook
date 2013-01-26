<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

class Book extends Core\Controller
{
	/**
	 * This function is called on each load on this controller.
	 *
	 * @access public
	 */
	public function init() {
		// Set variables
		$this->view->addVariable('book', Core\StoreRequest::get('book'));
		$this->view->addVariable('user', Core\StoreRequest::get('user'));
	}

	/**
	 * Allowing a book to be edited by the user.
	 *
	 * @access public
	 */
	public function editAction() {
		// Do nothing
	}

	/**
	 * Output the book.
	 *
	 * @access public
	 * @ajax
	 */
	public function pageAction() {
		// No layout required
		$this->setLayout(false);
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