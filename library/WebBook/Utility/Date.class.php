<?php
namespace WebBook\Utility;

/**
 * Handles all of the time and date functions.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 *
 * @todo This should use PHP's DateTime.
 */
class Date
{
	/**
	 * Return a date string from a timestamp
	 *
	 * @access public
	 * @param  int    $timestamp The UNIX timestamp.
	 * @param  string $dateRep   How we want the date represented.
	 * @return string
	 * @static
	 */
	public static function getDate($timestamp, $dateRep = 'jS F Y') {
		// Has the user even entered a timestamp?
		if ($timestamp == '' || $timestamp == 0) {
			return '&mdash;';
		}

		// Is the date representation a custom format?
		else if ($dateRep != 'jS F Y') {
			return date($dateRep, $timestamp);
		}

		// Is the timestamp a time today?
		else if (date('j/n/Y', $timestamp) == date('j/n/Y', time())) {
			return 'Today, ' . date('g:ia', $timestamp);
		}

		// Is the timestamp from yesterday?
		else if (date('j/n/Y', $timestamp) == date('j/n/Y', time() - 86400)) {
			return 'Yesterday';
		}

		// Just return the default timestamp
		return date($dateRep, $timestamp);
	}

	/**
	 * Return the hours/minutes between two timestamps.
	 *
	 * @access public
	 * @param  int    $timestampStart
	 * @param  int    $timestampEnd
	 * @return string
	 * @static
	 */
	public static function getDifference($timestampStart, $timestampEnd) {
		// First, is the late date later than the early date?
		if ($timestampStart > $timestampEnd) {
			return 'In the future..';
		}

		// Work out the difference
		$difference = $timestampEnd - $timestampStart;

		// Is this more than one day?
		if ($difference >= 86400) {
			// We are dealing with at least 1 day ago
			$days = $difference / 86400;

			// Work out the seconds
			$week = 86400 * 7;
			$month = $week * 4;
			$year = $week * 52;

			// More than a year?
			if ($difference > $year) {
				// How many years
				$period = floor($difference / $year);
				return $period . ($period >= 2 ? ' years' : ' year');
			}

			// More than a month?
			if ($difference > $month) {
				// How many months
				$period = floor($difference / $month);
				return $period . ($period >= 2 ? ' months' : ' month');
			}

			// More than a week?
			if ($difference > $week) {
				// How many months
				$period = floor($difference / $week);
				return $period . ($period >= 2 ? ' weeks' : ' week');
			}

			// How many days?
			$period = floor($difference / $week);
			return date('l, g:ia', $period);
		}

		// We are dealing with something within the past 24 hours
		// Within the past minute?
		if ($difference < 60) {
			return $difference . ($difference >= 2 ? ' seconds' : ' second');
		}

		// Within the past hour?
		if ($difference < 3600) {
			// How many minutes
			$period = floor($difference / 60);
			return $period . ($period >= 2 ? ' minutes' : ' minute');
		}

		// More than an hour ago
		$period = floor($difference / 3600);
		return $period . ($period >= 2 ? ' hours' : ' hours');
	}
}