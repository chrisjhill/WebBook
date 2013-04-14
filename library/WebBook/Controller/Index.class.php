<?php
namespace WebBook\Controller;
use Core, WebBook\Model, WebBook\Utility;

/**
 * The public aspect of the site.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Index extends Core\Controller
{
	/**
	 * Provides common functionality to this controllers actions.
	 *
	 * @access public
	 */
	public function init() {
		// We set the layout to default here because we may have been redirected.
		$this->setLayout('default');
	}

	/**
	 * The first page of the site.
	 *
	 * @access public
	 */
	public function indexAction() {
		// Link to the default book
		$book = new Model\Book\Instance(true, false);
		$book->book_id    = 1;
		$book->book_title = 'It\'s a Kind of Magic';
		$this->view->addVariable('urlBookEdit', Utility\Url::bookEdit($book));
	}
}