<?php
namespace WebBook\View\Helper;
use Core;

/**
 * Outputs a chapter subtitle.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class SectionSubtitle extends Core\ViewHelper
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
		return $this->renderPartial('Section/Subtitle', array(
			'sectionId'      => $params['section']->section_id,
			'sectionOrder'   => $params['section']->section_order,
			'wordCount'      => $params['section']->section_word_count,
			'sectionContent' => $params['section']->section_content,
			'sectionCanEdit' => $this->view->getVariable('readonly'),
			'chapterId'      => $params['section']->chapter_id
		));
	}
}