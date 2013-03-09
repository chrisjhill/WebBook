/**
 * Handles inserting and deleting chapters.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       08/03/2013
 */
WEBBOOK.Chapter = {
	// Vars
	chapterSelector:       ".chapter",
	chapterInsertSelector: ".chapter-insert",
	chapterDeleteSelector: ".chapter-delete",

	// DOM references
	$chapter: undefined,

	/**
	 * Sets up the chapter handling.
	 *
	 * @listens Chapter_Insert On Click Insert a new chapter.
	 * @listens Chapter_Delete On Click Delete the chapter.
	 *
	 * @listens Chapter_Inserted A new chapter has been inserted, reindex the chapters.
	 */
	init: function() {
		// Set DOM references
		this.$chapter = $(this.chapterSelector);

		// Listeners
		WEBBOOK.Book.$book.on("click", this.chapterInsertSelector, $.proxy(this.insert, this));
		// WEBBOOK.Book.$book.on("click", this.chapterDeleteSelector, $.proxy(this.delete, this));

		// Listeners (via triggers)
		$(document).on("Chapter_Inserted", $.proxy(this.chapterReindex, this));
	},

	/**
	 * A chapter has been inserted or deleted, reindex the chapters.
	 *
	 * @param Event e
	 */
	chapterReindex: function(e) {
		this.$chapter = $(this.chapterSelector);
	},

	/**
	 * Inserts a new chapter into the book.
	 *
	 * @param Event e
	 *
	 * @triggers Chapter_Inserted If we managed to insert the chapter.
	 */
	insert: function(e) {
		// Get the chapter DOM element
		var $el = $(e.currentTarget).parents(this.chapterSelector);

		// The order of the new section
		var order = parseInt($el.data("chapterid")) + 1;

		// Increment the sections *after* this new section will be added
		this.$chapter.filter(function() {
			if (parseInt($(this).data("chapterid")) >= order) {
				$(this).data().chapterid++;
			}
		});

		// Insert the section via Ajax
		$.ajax({
			url:    "/chapter/insert",
			method: "post",
			data:   {
				chapter_id: order
			},
			success: function(data) {
				// Set the content
				$el.after(data).next(WEBBOOK.Chapter.chapterSelector)
					.focus()
					.animate({ backgroundColor: "#FFFFAA" }, 750)
					.animate({ backgroundColor: "#FFFFFF" }, 2000);

				// Let others know what just happened
				$(document).trigger({ type: "Chapter_Inserted" });
				$(document).trigger({ type: "Section_Inserted" });
			},
			error: function() {
				alert("Sorry, we were unable to load the page :(");
			}
		});

		return false;
	},

	/**
	 * Deletes a chapter from the book.
	 *
	 * @param Event e
	 *
	 * @triggers Chapter_Deleted If we managed to delete the chapter.
	 */
	remove: function() {
		return false;
	}
}