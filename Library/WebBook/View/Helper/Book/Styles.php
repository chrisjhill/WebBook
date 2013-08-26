<?php
namespace WebBook\View\Helper\Book;
use Core;

/**
 * Outputs the custom CSS styles for a book.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class Styles extends Core\ViewHelper
{
	/**
	 * Outputs the custom CSS styles for a book.
	 *
	 * <code>
	 * array(
	 *    // Empty
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		// Get the settings for the book
		$settings = Core\Store\Request::get('settings');

		// Place the chapter's sections into a chapter
		return $this->renderPartial('Book/Styles', array(
			'background' => $this->getBackground($settings->setting_background),
			'shadow'     => $this->getShadow($settings->setting_background),
			'alignment'  => $this->getAlignment($settings->setting_alignment),
			'padding'    => $this->getPadding($settings->setting_page_paddings),
			'font'       => $this->getFont(
				$settings->setting_font_color,
				$settings->setting_font_size,
				$settings->setting_font_family,
				$settings->setting_line_height
			),
		));
	}

	/**
	 * What background the user wants for this book.
	 *
	 * @access public
	 * @param  string $background The background that the user has set.
	 * @return string
	 */
	public function getBackground($background) {
		switch ($background) {
			// Images
			case 'squares'  : return 'background:#EEE url(/assets/img/body-bg-squares.png) fixed top left'; break;
			case 'wood'     : return 'background:#EEE url(/assets/img/body-bg-wood.jpg)    fixed top left'; break;
			// Colours
			case 'white'    : return 'background:#FFF'; break;
			case 'grey'     : return 'background:#CCC'; break;
			case 'greyer'   : return 'background:#888'; break;
			case 'charcoal' : return 'background:#444'; break;
			case 'black'    : return 'background:#000'; break;
			// Not sure...
			default         : return '';                break;
		}
	}


	/**
	 * What kind of shadow the user wants on the book page.
	 *
	 * @access public
	 * @param  string $background The shadow is dependent on what background the book has.
	 * @return string
	 */
	public function getShadow($background) {
		switch ($background) {
			// Images
			case 'squares'  : return 'box-shadow:0px 0px 5px 2px #DDD';    break;
			case 'wood'     : return 'box-shadow:0px 0px 5px 2px #c49a6a'; break;
			// Colours
			case 'white'    : return 'box-shadow:0px 0px 5px 2px #EEE';    break;
			case 'grey'     : return 'box-shadow:0px 0px 5px 2px #BBB';    break;
			case 'greyer'   : return 'box-shadow:0px 0px 5px 2px #777';    break;
			case 'charcoal' : return 'box-shadow:0px 0px 5px 2px #333';    break;
			case 'black'    : return ''; break;
			//Not sure...
			default         : return ''; break;
		}
	}

	/**
	 * What font does the user want?
	 *
	 * @access public
	 * @param  string $fontColor  What color the user wants the font.
	 * @param  string $fontSize   How big the font size should be.
	 * @param  string $fontFamily Which font family for the text.
	 * @param  string $lineHeight How much space between each line of text.
	 * @return string
	 */
	public function getFont($fontColor, $fontSize, $fontFamily, $lineHeight) {
		// Build the string we want to return
		$output =
		      'color:#' . $fontColor . ';'
			. 'font:'   . $fontSize  . 'px/'
			. $lineHeight . 'em ';

		// Which font?
		switch ($fontFamily) {
			case 'helvetica' :
				return $output . 'Helvetica,Arial,"Liberation sans","Bitstream Vera Sans",sans-serif';
				break;
			case 'arial' :
				return $output . 'Arial,Helvetica,"Liberation sans","Bitstream Vera Sans",sans-serif';
				break;
			case 'georgia':
				return $output . 'Georgia,"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif';
				break;
			default:
				return $output . '"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif';
				break;
		}
	}

	/**
	 * The users custom alignment.
	 *
	 * @access public
	 * @param  string $alignment The text alignment the user wants for th book.
	 * @return string
	 */
	public function getAlignment($alignment) {
		return 'text-align:' . $alignment;
	}

	/**
	 * The users custom padding.
	 *
	 * @access public
	 * @param  string $padding How much padding the user wants on their book.
	 * @return string
	 */
	public function getPadding($padding) {
		// What is the width of the editable content area?
		$totalWidth = 850;

		// Minus the padding from the right
		$totalWidth = $totalWidth - ($padding * 2);

		// And send the padding
		return 'width:' . $totalWidth . 'px;padding:' . $padding . 'px';
	}
}