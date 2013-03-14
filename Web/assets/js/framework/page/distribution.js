/**
 * Handles the distribution page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       14/03/2013
 */
WEBBOOK.Distribution = {
	// Vars
	updateSelector:        "#distribution-update",

	distributionRadioName: "book-distribution",

	// DOM references
	$update: undefined,

	/**
	 * Sets up the event listeners.
	 *
	 * @listens Update On Click
	 */
	init: function() {
		// Set DOM references
		this.$update = $(this.updateSelector);

		// Listeners
		this.$update.on("click", $.proxy(this.update, this));
	},

	/**
	 * Updates the settings.
	 *
	 * @param Event event
	 *
	 * @triggers Content_Update If our Ajax request was successful.
	 * @triggers Notice         If success or failure.
	 */
	update: function(event) {
		$.ajax({
			url:  "/distribution/update",
			type: "post",
			data: {
				book_distribution: $("input:radio[name="+this.distributionRadioName+"]:checked").val()
			},
			success: function(data) {
				// Save the content
				$(document).trigger({ type: "Content_Update" }, "distribution");

				// Display the notice
				$(document).trigger({ type: "Notice" }, data);
			}
		});

		return false;
	}
}

WEBBOOK.Distribution.init();