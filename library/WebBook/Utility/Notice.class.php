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
	 * @var string
	 */
	private $_outcome;

	/**
	 * The messages to be shown
	 *
	 * @var array
	 */
	private $_message = array();

	/**
	 * Any introductory text
	 *
	 * @var string
	 */
	private $_intro;

	/**
	 * A custom notice/success/error message
	 *
	 * @var string
	 */
	private $_customMessage;

	/**
	 * Sets the outcome and messages
	 *
	 * @param string $outcome
	 * @param array $message
	 * @param boolean $output
	 * @return string
	 */
	public function __construct($outcome = null, $message = null, $output = false) {
		$this->setOutcome($outcome);
		$this->setMessage($message);

		if ($output) {
			return $this->getMessage();
		}
	}

	/**
	 * Set the outcome of the message
	 *
	 * @param string $outcome
	 */
	public function setOutcome($outcome) {
		$this->_outcome = in_array($outcome, array('error', 'success', 'info')) ? $outcome : 'info';
	}

	/**
	 * Set the message to output
	 *
	 * @param mixed $message
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
	 * @param string $intro
	 */
	public function setIntro($intro) {
		$this->_intro = $intro;
	}

	/**
	 * Sets a custom message for the notice/success/error
	 *
	 * @param string $message
	 */
	public function setCustomMessage($message) {
		$this->_customMessage = $message;
	}

	/**
	 * Is there a message to show?
	 *
	 * @return unknown
	 */
	public function getIsMessagePending() {
		return empty($this->_outcome) ? false : true;
	}

	/**
	 * Returns what type of message this is
	 *
	 * @return string
	 */
	public function getOutcome() {
		return $this->_outcome;
	}

	/**
	 * Begining of the output
	 *
	 * @param boolean $showAsSingle
	 * @return string
	 */
	public function getMessage($showAsSingle = false) {
		// Is there anything to output?
		if (strlen($this->_intro) <= 0 && empty($this->_message[0]) && empty($this->_message[1]) && empty($this->_customMessage)) {
			return '';
		}

		$output = null;

		// Get the top of the messsage
		$minimize = '';// <small><a href="#" class="notice_mimimize"><img src="' . $_SERVER['SITE'] . 'public/images/action_minimize.gif" alt="-" /></a></small>';
		if (strlen($this->_customMessage) >= 1) {
			$output = '<h3>' . $this->_customMessage . $minimize . '</h3>';
		}
		else {
			switch ($this->_outcome) {
				case 'error'
					: $output = '<h3>Oh Dear. An error has occurred!' . $minimize . '</h3>'; break;
				case 'success'
					: $output = '<h3>Your action has been successful' . $minimize . '</h3>'; break;
				default
					: $output = '<h3>Some information you might find useful:' . $minimize . '</h3>'; break;
			}
		}

		// Add the introductory message, if necessary
		if ($this->_intro) {
			$output .= '<p>' . $this->_intro . '</p>';
		}

		// Get the actual message
		if (!empty($this->_message[0]) || !empty($this->_message[1])) {
			$output .= '<ul>';

			foreach ($this->_message as $key => $value) {
				if (!empty($value)) {
					$output .= '<li>' . $value . '</li>';
				}
			}

			$output .= '</ul>';
		}

		return '<div class="notice ' . ($showAsSingle ? 'notice-single ' : '') . $this->_outcome . '">' . $output . '</div>';
	}

	/**
	 * Used when outputting a message as default
	 *
	 * @return mixed
	 */
	public function __tostring() {
		return $this->getMessage();
	}
}