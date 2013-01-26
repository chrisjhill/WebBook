<?php
namespace WebBook\View\Helper;
use Core;

/**
 * Outputs a chapter.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       25/01/2013
 */
class SectionChapterTitle extends Core\ViewHelper
{
	/**
	 * Outputs a book title.
	 *
	 * <code>
	 * array(
	 *     'section' => Section\Instance
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		return $this->renderPartial('Section/ChapterTitle', array(
			'sectionId'      => $params['section']->section_id,
			'sectionOrder'   => $params['section']->section_order,
			'wordCount'      => $params['section']->section_word_count,
			'sectionContent' => $params['section']->section_content,
			'sectionCanEdit' => true,
			'chapterId'      => $params['section']->chapter_id
		));
	}
}