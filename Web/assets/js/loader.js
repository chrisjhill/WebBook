/**
 * Handles initiating the JavaScript assets on page load.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       27/01/2013
 */
WEBBOOK.Loader = {
	/**
	 * Init framework assets.
	 *
	 */
	init: function() {
		// Core
		WEBBOOK.Store.init();
		WEBBOOK.Content.init();
		WEBBOOK.Notice.init();
		WEBBOOK.Nav.init();
		// Book editing
		WEBBOOK.Book.init();
		WEBBOOK.Chapter.init();
		WEBBOOK.Section.init();
		WEBBOOK.Wysiwyg.init();
		WEBBOOK.Fullscreen.init();
	}
}