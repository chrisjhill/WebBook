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
		$diff = $start->diff($end);

		// And return
		switch (true) {
			case $diff->y > 0 : return $diff->y . ' year'   . ($diff->y > 1 ? 's' : '') . ' ago';
			case $diff->m > 0 : return $diff->m . ' month'  . ($diff->m > 1 ? 's' : '') . ' ago';
			case $diff->d > 0 : return $diff->d . ' day'    . ($diff->d > 1 ? 's' : '') . ' ago';
			case $diff->h > 0 : return $diff->h . ' hour'   . ($diff->h > 1 ? 's' : '') . ' ago';
			case $diff->i > 0 : return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
			case $diff->s > 0 : return $diff->s . ' second' . ($diff->s > 1 ? 's' : '') . ' ago';

			default: return 'Just now';
		}
	}
}