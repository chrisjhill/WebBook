<?php
namespace WebBook\Controller;
use Core;

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
	 * The index action
	 *
	 * @access public
	 */
	public function editAction() {
		// Do nothing
	}


	public function pageAction() {

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