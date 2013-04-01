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
		$(document).on("Notice", function(event, data) {
			// Just passed in a message
			if (typeof data == "string") {
				return WEBBOOK.Notice.display(data);
			}

			// Programatically
			WEBBOOK.Notice.display(data.message, data.status);
		});
	},

	/**
	 * Displays the notice to the user.
	 *
	 * This can be called in two ways:
	 *
	 * 1. Via pure HTML, generally from Ajax requests.
	 * 2. Programatically.
	 *
	 * @param string message The message that we want to display to the user.
	 * @param string status  Whether it successed, error'd, or a info.
	 */
	display: function(message, status) {
		// If the status is missing, then it is from an Ajax request
		// We will already have all we need
		if (typeof status === "undefined") {
			return this.$content.html(message).slideDown().delay(3000).slideUp();
		}

		// Make sure the status is valid
		switch (status) {
			case "success" : // Run through
			case "error"   : status = status.toLowerCase(); break;
			default        : status = "info";
		}

		// Display the notice and automatically remove after x seconds
		this.$content
			.html('<p class="notice notice-' + status + '">'
				+ '    <strong>' + message + '</strong>'
				+ '</p>')
			.slideDown()
			.delay(3000)
			.slideUp();
	}
}