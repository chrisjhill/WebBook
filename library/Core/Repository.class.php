<?php
namespace Core;

/**
 * Handles storing data on an entity, ready for use.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       20/01/2013
 */
class Repository
{
	/**
	 * Store for the information on the entity.
	 *
	 * @access private
	 * @var    array
	 */
	private $_store = array();

	/**
	 * Import all of the data for a single entity.
	 *
	 * @access public
	 * @param  array  $data All the data of a single entity.
	 */
	public function import($data) {
		$this->_store = $data;
	}

	/**
	 * Set a variable for this entity.
	 *
	 * @access public
	 * @param  string $variable The name of the variable we wish to set.
	 * @param  mixed  $value    The value of the variable we wish to set.
	 */
	public function __set($variable, $value) {
		$this->_store[$variable] = $value;
	}

	/**
	 * Return a variable.
	 *
	 * @access public
	 * @param  string $variable The name of the variable we wish to return.
	 * @return mixed
	 */
	public function __get($variable) {
		// Do we even have this piece of data?
		if (! isset($this->_store[$variable])) {
			throw new \Exception('Could not locate the ' . $variable . ' in repository.');
		}

		return $this->_store[$variable];
	}
}