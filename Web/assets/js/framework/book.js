/**
 * Handles inserting and deleting chapters.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       08/03/2013
 */
WEBBOOK.Book = {
	// Vars
	bookSelector: "#book",
	bookId:       undefined,

	// DOM references
	$book: undefined,

	/**
	 * Sets up the chapter handling.
	 *
	 */
	init: function() {
		// Set DOM references
		this.$book = $(this.bookSelector);
	}
}