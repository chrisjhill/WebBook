<?php
namespace WebBook\Utility;

/**
 * Displays outputs from errors, success, or notice messages
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     22/10/2012
 *
 * @todo This should be a View Helper.
 */
class Notice
{
	/**
	 * What type of message we are showing
	 *
	 * @access private
	 * @var    string
	 */
	private $_outcome;

	/**
	 * The messages to be shown
	 *
	 * @access private
	 * @var    array
	 */
	private $_message = array();

	/**
	 * Any introductory text
	 *
	 * @access private
	 * @var    string
	 */
	private $_intro;

	/**
	 * A custom notice/success/error message
	 *
	 * @access private
	 * @var    string
	 */
	private $_customMessage;

	/**
	 * Sets the outcome and messages
	 *
	 * @access public
	 * @param  string  $outcome
	 * @param  array   $message
	 * @param  boolean $output
	 */
	public function __construct($outcome = null, $message = null) {
		$this->setOutcome($outcome);
		$this->setMessage($message);
	}

	/**
	 * Set the outcome of the message
	 *
	 * @access public
	 * @param  string $outcome
	 */
	public function setOutcome($outcome) {
		$this->_outcome = in_array($outcome, array('error', 'success', 'info')) ? $outcome : 'info';
	}

	/**
	 * Set the message to output
	 *
	 * @access public
	 * @param  mixed  $message
	 */
	public function setMessage($message) {
		if (is_array($message)) {
			foreach ($message as $value) {
				$this->_message[] = $value;
			}
		} else {
			$this->_message[] = $message;
		}
	}

	/**
	 * Sets the introductory text
	 *
	 * @access public
	 * @param  string $intro
	 */
	public function setIntro($intro) {
		$this->_intro = $intro;
	}

	/**
	 * Sets a custom message for the notice/success/error
	 *
	 * @access public
	 * @param  string $message
	 */
	public function setCustomMessage($message) {
		$this->_customMessage = $message;
	}

	/**
	 * Is there a message to show?
	 *
	 * @access public
	 * @return boolean
	 */
	public function getIsMessagePending() {
		return empty($this->_outcome) ? false : true;
	}

	/**
	 * Returns what type of message this is
	 *
	 * @access public
	 * @return string
	 */
	public function getOutcome() {
		return $this->_outcome;
	}

	/**
	 * Begining of the output
	 *
	 * @access public
	 * @return string
	 */
	public function getMessage() {
		// Is there anything to output?
		if (strlen($this->_intro) <= 0 && empty($this->_message[0]) && empty($this->_message[1]) && empty($this->_customMessage)) {
			return '';
		}

		$output = null;

		// Get the top of the messsage
		if (isset($this->_customMessage[0])) {
			$output = '<h3>' . $this->_customMessage . $minimize . '</h3>';
		} else {
			switch ($this->_outcome) {
				case 'error'
					: $output = '<h3>Oh Dear. An error has occurred!</h3>'; break;
				case 'success'
					: $output = '<h3>Your action has been successful</h3>'; break;
				default
					: $output = '<h3>Some information you might find useful:</h3>'; break;
			}
		}

		// Add the introductory message, if necessary
		if ($this->_intro) {
			$output .= '<p>' . $this->_intro . '</p>';
		}

		// Get the actual message
		if (!empty($this->_message[0]) || !empty($this->_message[1])) {
			$output .= '<ul><li>' . implode('</li></li>', $this->_message) . '</li></ul>';
		}

		return '<div class="notice notice-' . $this->_outcome . '">' . $output . '</div>';
	}

	/**
	 * Used when outputting a message as default
	 *
	 * @access public
	 * @return string
	 */
	public function __tostring() {
		return $this->getMessage();
	}
}