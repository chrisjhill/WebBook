<?php
namespace WebBook\Model;
use Core;

/**
 * Formats a URL into a pretty string ready for use in URL's.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     22/10/2012
 *
 * @todo This belongs in a View Helper.
 */
class Url
{
	/**
	 * Strips all invalid characters out of the string and returns.
	 *
	 * @access public
	 * @param  string $url The URL we need to parse.
	 * @return string
	 * @static
	 */
	public static function parse($url) {
		return
			preg_replace(
				"/[^a-z0-9-]/",
				"",
				strtolower(
					str_replace(' ', '-', $url)
				)
			);
	}
}