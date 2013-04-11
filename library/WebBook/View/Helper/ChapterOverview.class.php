<?php
namespace WebBook\View\Helper;
use Core;

/**
 * Outputs the chapter overview view.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class ChapterOverview extends Core\ViewHelper
{
	/**
	 * Outputs the chapter overview view.
	 *
	 * <code>
	 * array(
	 *     'book' => Model\Book
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		// Create a container for the section HTML
		$chapterHtml = '';

		// Loop over each chapter and add the HTML to the return variable
		foreach ($params['book'] as $chapterId => $chapter) {
			// Get the first section which will be the chapter title
			foreach ($chapter as $sectionId => $section) {
				// Place the chapter's sections into a chapter
				$chapterHtml .= $this->renderPartial('ChapterOverviewItem', array(
					'chapterId'    => $section->chapter_id,
					'chapterTitle' => $section->section_content
				));
				break;
			}
		}

		return $chapterHtml;
	}
}