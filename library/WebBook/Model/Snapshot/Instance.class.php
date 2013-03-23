<?php
namespace WebBook\Model\Snapshot;
use WebBook\View\Helper;

/**
 * Contains information on the snapshots a user has taken.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Instance extends Repository implements \IteratorAggregate
{
	/**
	 * A collection of snapshot arrays.
	 *
	 * @access private
	 * @var    array
	 */
	private $_store = array();

	/**
	 * Create a new Snapshot\Instance.
	 *
	 * @access public
	 * @param  string $book_id The ID of the book.
	 */
	public function __construct($data = array()) {
		$this->import($data);
	}

	/**
	 * Get the snapshots that the user has taken.
	 *
	 * @access public
	 */
	public function setData() {
		$data = $this->get();
		while ($snapshot = $data->fetch()) {
			$this->_store[] = $snapshot;
		}
	}

	/**
	 * Allow scripts to iterate over the snapshots.
	 *
	 * @access public
	 * @return Section\Instance
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_store);
	}
}