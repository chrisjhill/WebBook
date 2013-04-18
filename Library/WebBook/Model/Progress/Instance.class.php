<?php
namespace WebBook\Model\Progress;
use WebBook\View\Helper;

/**
 * Handles the progression of the book.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Instance extends Repository implements \IteratorAggregate
{
	/**
	 * Data on the progression of the book.
	 *
	 * @access private
	 * @var    array
	 */
	public $store;

	/**
	 * Create a new Progress\Instance.
	 *
	 * @access public
	 * @param  array  $data All of the information for this progression.
	 */
	public function __construct($data = array()) {
		$this->import($data);
	}

	/**
	 * Get the progressions that the user has made.
	 *
	 * @access public
	 * @param  int    $limit How many progressions to return.
	 */
	public function setData($limit = 365) {
		$progressions = $this->get($limit);

		while ($progress = $progressions->fetch()) {
			$this->store[] = $progress;
		}
	}

	/**
	 * Allow scripts to iterate over the progressions.
	 *
	 * @access public
	 * @return Chapter\Instance
	 */
	public function getIterator() {
		return new \ArrayIterator($this->store);
	}
}