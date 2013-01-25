<?php
namespace WebBook\Model\Section;
use WebBook\View\Helper;

/**
 * Contains information on a section in a chapter.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.2
 * @since     20/01/2013
 */
class Instance extends Repository
{
	/**
	 * Create a new Section\Instance.
	 *
	 * @access public
	 * @param  array  $data All of the information on this section.
	 */
	public function __construct($data = array()) {
		$this->import($data);
	}

	/**
	 * Output the section to the page.
	 *
	 * A section can be one of many different types of sections, so it needs
	 * to output the correct one.
	 *
	 * @access public
	 * @return string The HTML output
	 */
	public function output() {
		switch ($this->section_type) {
			case 'booktitle'    : $partial = new Helper\SectionBookTitle();    break;
			case 'author'       : $partial = new Helper\SectionAuthor();       break;
			case 'chaptertitle' : $partial = new Helper\SectionChapterTitle(); break;
			case 'subtitle'	    : $partial = new Helper\SectionSubtitle();     break;
			case 'content'	    : $partial = new Helper\SectionContent();      break;
		}

		return $partial->render(array(
			'section' => $this
		));
	}
}