/**
 * Handles the snapshot.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       21/03/2013
 */
WEBBOOK.Snapshot = {
	// Vars
	tableSelector:  "#snapshots",
	saveSelector:   "#snapshot-save",
	removeSelector: ".snapshot-remove",

	// DOM references
	$table: undefined,
	$save:  undefined,

	/**
	 * Sets up the event listeners.
	 *
	 * @listens Remove on Click
	 */
	init: function() {
		// Set DOM references
		this.$table = $(this.tableSelector);
		this.$save  = $(this.saveSelector);

		// Listeners
		this.$save.on("click",                       $.proxy(this.save,   this));
		this.$table.on("click", this.removeSelector, $.proxy(this.remove, this));
	},

	/**
	 * Save a snapshot.
	 *
	 * @param Event event
	 */
	save: function(event) {
		$.ajax({
			url:  "/snapshot/save",
			type: "post",
			data: {
				book_id: WEBBOOK.Book.bookId
			},
			success: function(data) {
				// Display the notice
				$(document).trigger({ type: "Notice" }, {
					status:  "success",
					message: "Snapshot has successfully been saved."
				});

				// And create the row
				$("#secondary table").append('<tr>'
					+ '<td>Today</td>'
					+ '<td>Just now</td>'
					+ '<td>'
					+ '    <a href="/book/snapshot/' + WEBBOOK.Book.bookId + '/' + data + '" target="_blank" class="snapshot-view button white medium">'
					+ '        View'
					+ '    </a>'
					+ '</td>'
					+ '<td>'
					+ '    <a href="#" class="snapshot-remove button white medium" data-snapshotid="' + data + '">'
					+ '        Remove'
					+ '    </a>'
					+ '</td>');
			}
		});

		return false;
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