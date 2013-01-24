<?php
namespace WebBook\Model\Section;

/**
 * A list of all the sections in a chapter.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       20/01/2013
 */
class Collection
{
	/**
	 * An array of the chapter's sections.
	 *
	 * @access public
	 * @var    array  An collection of Section\Instance's
	 */
	public $store = array();

	/**
	 * Add a section to the chapter.
	 *
	 * @access public
	 * @param  Section\Instance  $section The section to add.
	 * @throws Exception                  If $section is not a Section\Instance.
	 */
	public function add($section) {
		if (get_class($section) != 'WebBook\Model\Section\Instance') {
			throw new \Exception('Expecting a Section class.');
		}

		$this->store[$section->section_id] = $section;
	}
}