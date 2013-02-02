<?php
namespace WebBook\View\Helper;
use Core;

/**
 * Displays outputs from errors, success, or notice messages.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.2
 * @since     22/10/2012
 *
 * @update    02/02/2013 Greatly simplified this class and moved into View Helper.
 */
class Notice extends Core\ViewHelper
{
	/**
	 * What type of message we are showing.
	 *
	 * @access private
	 * @var    string
	 */
	private $_outcome;

	/**
	 * The gist of the message.
	 *
	 * E.g., Oh dear, an error has occurred!
	 *
	 * @access private
	 * @var    array
	 */
	private $_messageOutcome;

	/**
	 * The description message.
	 *
	 * E.g., We were unabele to update because you have missing fields.
	 *
	 * @access private
	 * @var    string
	 */
	private $_message;

	/**
	 * Sets the outcome and messages.
	 *
	 * @access public
	 * @param  string  $outcome        What type of message we are showing.
	 * @param  array   $messageOutcome The gist of the message.
	 * @param  boolean $message        The description message.
	 */
	public function __construct($outcome = 'info', $messageOutcome = null, $message = null) {
		$this->setOutcome($outcome);
		$this->_messageOutcome = $messageOutcome;
		$this->_message        = $message;
	}

	/**
	 * Set the outcome of the message
	 *
	 * @access public
	 * @param  string  $outcome              What type of message we are showing.
	 * @param  boolean $updateMessageOutcome Whether or not to set the outcome message.
	 * @return Notice
	 * @chainable
	 */
	public function setOutcome($outcome, $updateMessageOutcome = true) {
		$this->_outcome = $outcome;

		// Set the message outcome
		if ($updateMessageOutcome) {
			switch ($this->_outcome) {
				case 'error' :
					$this->_messageOutcome = '<strong>Oh Dear, an error has occurred</strong>';
					break;
				case 'success' :
					$this->_messageOutcome = '<strong>Your action has been successful</strong>';
					break;
				default :
					$this->_messageOutcome = '<strong>Some information you might find useful</strong>';
			}
		}

		return $this;
	}

	/**
	 * Set the gist of the message.
	 *
	 * @access public
	 * @param  string $messageOutcome The gist of the message.
	 * @return Notice
	 * @chainable
	 */
	public function setMessageOutcome($messageOutcome) {
		$this->_messageOutcome = $messageOutcome;
		return $this;
	}

	/**
	 * Set the description message.
	 *
	 * @access public
	 * @param  string $message The description message.
	 * @return Notice
	 * @chainable
	 */
	public function setMessage($message) {
		$this->_message = $message;
		return $this;
	}

	/**
	 * Output the notice.
	 *
	 * @access public
	 * @return string
	 */
	public function render() {
		return $this->renderPartial('Notice', array(
			'outcome'        => $this->_outcome,
			'messageOutcome' => $this->_messageOutcome,
			'message'        => $this->_message
		));
	}
}