<?php
namespace WebBook\View\Helper\Book;
use Core;

/**
 * Outputs a single chapter.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class Chapter extends Core\ViewHelper
{
	/**
	 * Outputs a single chapter.
	 *
	 * <code>
	 * array(
	 *     'chapter'          => Model\Chapter\Collection,
	 *     'chapterId'        => 123,
	 *     'chapterCanRemove' => true
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		// Create a container for the section HTML
		$sectionHtml = '';

		// Loop through each section in the chapter
		foreach ($params['chapter'] as $section) {
			$sectionHtml .= $section->output();
		}

		// Place the chapter's sections into a chapter
		return $this->renderPartial('Book/Chapter', array(
			'chapterId'        => $params['chapterId'],
			'sectionHtml'      => $sectionHtml,
			'chapterCanAdd'    => ! $this->view->getVariable('readonly'),
			'chapterCanRemove' => $params['chapterCanRemove']
		));
	}
}