<?php
namespace WebBook\Utility;
use Core;

/**
 * Handles all of the time and date functions.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Date
{
	/**
	 * Return a date string from a timestamp.
	 *
	 * @access public
	 * @param  int    $timestamp The Unix timestamp.
	 * @param  string $dateRep   How we want the date represented.
	 * @return string
	 * @static
	 */
	public static function getDate($timestamp, $dateRep = 'jS F Y') {
		// Has the user even entered a timestamp?
		if (empty($timestamp)) {
			return '&mdash;';
		}

		// Create the DateTime object for some further manipulations
		$date = new \DateTime();
		$date->setTimestamp($timestamp);
		return $date->format($dateRep);
	}

	/**
	 * Return the difference between two timestamps.
	 *
	 * @access public
	 * @param  int    $timestampStart
	 * @param  int    $timestampEnd
	 * @return string
	 * @static
	 */
	public static function getDifference($timestampStart, $timestampEnd) {
		// Start and end dates
		$start = new \DateTime();
		$start->setTimestamp($timestampStart);

		$end = new \DateTime();
		$end->setTimestamp($timestampEnd);

		// Working out the differents
		$diff    = $start->diff($end);
		$years   = $diff->format('%y');
		$months  = $diff->format('%m');
		$days    = $diff->format('%d');
		$hours   = $diff->format('%G');
		$minutes = $diff->format('%i');
		$seconds = $diff->format('%s');

		// And return
		if ($years > 0) {
			return $years   . ' year'   . ($years   > 1 ? 's' : '') . ' ago';
		} else if ($months  > 0) {
			return $years   . ' month'  . ($months  > 1 ? 's' : '') . ' ago';
		} else if ($days    > 0) {
			return $days    . ' day'    . ($days    > 1 ? 's' : '') . ' ago';
		} else if ($hours   > 0) {
			return $hours   . ' hour'   . ($hours   > 1 ? 's' : '') . ' ago';
		} else if ($minutes > 0) {
			return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
		} else if ($seconds > 0) {
			return $seconds . ' second' . ($seconds > 1 ? 's' : '') . ' ago';
		}

		return 'just now';
	}
}