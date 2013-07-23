<?php
namespace WebBook\Model\Section;
use WebBook\View\Helper;

/**
 * Contains information on a section in a chapter.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
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
			case 'booktitle'    : $partial = new Helper\Book\Section\BookTitle();    break;
			case 'author'       : $partial = new Helper\Book\Section\Author();       break;
			case 'chaptertitle' : $partial = new Helper\Book\Section\ChapterTitle(); break;
			case 'subtitle'	    : $partial = new Helper\Book\Section\Subtitle();     break;
			case 'content'	    : $partial = new Helper\Book\Section\Content();      break;
		}

		return $partial->render(array(
			'section' => $this
		));
	}
}