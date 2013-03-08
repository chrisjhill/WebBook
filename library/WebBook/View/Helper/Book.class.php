<?php
namespace WebBook\View\Helper;
use Core;

/**
 * Outputs an entire book to the page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       26/01/2013
 */
class Book extends Core\ViewHelper
{
	/**
	 * Outputs an entire book to the page.
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		// Get the book
		$book = Core\StoreRequest::get('book');

		// Placeholder for each chapter's HTML
		$chapterHtml  = '';

		// Loop through the chapters
		foreach ($book as $chapterId => $chapter) {
			// Place the chapter's sections into a chapter
			$chapterHtml .= $this->view->chapter(array(
				'chapter'   => $chapter,
				'chapterId' => $chapterId
			));
		}

		return $chapterHtml;
	}
}