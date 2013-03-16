/**
 * Handles the target page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Target = {
	// Vars
	updateSelector:                "#target-update",

	targetPercentCompleteSelector: ".target-pill-percent",

	targetWordCountSelector:       "#target-word-count",
	targetDateSelector:            "#target-date",

	progressGraphSelector:         "#target-graph",

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

		// And animate the book progression
		$(this.targetPercentCompleteSelector).animate({
			width: $(".target-pill-percent").data("percent")
		}, 1000, function() {
			$("span", this).fadeIn(1000);
		});
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
			url:  "/target/update",
			type: "post",
			data: {
				book_id:           WEBBOOK.Book.bookId,
				target_word_count: $(this.targetWordCountSelector).val(),
				target_date:       $(this.targetDateSelector).val()
			},
			success: function(data) {
				// Save the content
				$(document).trigger({ type: "Content_Update" }, "target");

				// Display the notice
				$(document).trigger({ type: "Notice" }, data);
			}
		});

		return false;
	}
}

WEBBOOK.Target.init();