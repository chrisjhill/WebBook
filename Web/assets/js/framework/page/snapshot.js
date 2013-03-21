/**
 * Handles the snapshot.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       21/03/2013
 */
WEBBOOK.Snapshot = {
	// Vars
	removeSelector: ".snapshot-remove",

	// DOM references
	$remove: undefined,

	/**
	 * Sets up the event listeners.
	 *
	 * @listens Remove on Click
	 */
	init: function() {
		// Set DOM references
		this.$remove = $(this.removeSelector);

		// Listeners
		this.$remove.on("click", $.proxy(this.remove, this));
	},

	/**
	 * Remove a snapshot.
	 *
	 * @param Event event
	 */
	remove: function(event) {
		// Set the remove button
		var $el = $(event.currentTarget);

		$.ajax({
			url:  "/snapshot/remove",
			type: "post",
			data: {
				book_id:     WEBBOOK.Book.bookId,
				snapshot_id: $el.data("snapshotid")
			},
			success: function(data) {
				// Remove the table row
				$el.parents("tr").remove();

				// Display the notice
				$(document).trigger({ type: "Notice" }, data);
			}
		});

		return false;
	}
}

WEBBOOK.Snapshot.init();