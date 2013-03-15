/**
 * Handles all of the page notices.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Notice = {
	// Vars
	contentSelector: "#notice-container",

	// DOM references
	$content: undefined,

	/**
	 * Listens for notice requests
	 *
	 * @listens Document On Notice
	 */
	init: function() {
		// Set DOM references
		this.$content = $(this.contentSelector);

		// Listeners
		$(document).on("Notice", function(event, message, status) {
			WEBBOOK.Notice.display(message, status);
		});
	},

	/**
	 * Displays the notice to the user.
	 *
	 * @param string message The message that we want to display to the user.
	 * @param string status  Whether it successed, error'd, or a info.
	 */
	display: function(message, status) {
		// If the status is missing, then it is from an Ajax request
		// We will already have all we need
		if (typeof status === "undefined") {
			this.$content.html(message).slideDown().delay(3000).slideUp();

			// @todo Needs finishing.
		}

		// @todo Notices made programatically.
	}
}