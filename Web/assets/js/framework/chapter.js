/**
 * Handles inserting and deleting chapters.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       08/03/2013
 */
WEBBOOK.Chapter = {
	// Vars
	bookSelector:          "#book",
	chapterSelector:       ".chapter",
	chapterInsertSelector: ".chapter-insert",
	chapterDeleteSelector: ".chapter-delete",

	// DOM references
	$book:    undefined,
	$chapter: undefined,

	/**
	 * Sets up the chapter handling.
	 *
	 * @listens ChapterInsert On Click
	 * @listens ChapterDelete On Click
	 */
	init: function() {
		// Set DOM references
		this.$book    = $(this.bookSelector);
		this.$chapter = $(this.chapterSelector);

		// Listeners
		this.$book.on("click", this.chapterInsertSelector, $.proxy(this.insert, this));
		// this.$book.on("click", this.chapterDeleteSelector, $.proxy(this.delete, this));
	},

	/**
	 * Inserts a new chapter into the book.
	 *
	 * @param Event e
	 */
	insert: function(e) {
		// Get the chapter DOM element
		var $el = $(e.currentTarget).parents(this.chapterSelector);

		// Get the chapter ID
		var chapterId = $el.data("chapterid");

		// The order of the new section
		var order = chapterId++;

		// Increment the sections *after* this new section will be added
		this.$chapter.filter(function() {
			return $(this).data("chapterid") >= order;
		}).data().order++;

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
	 */
	remove: function() {
		return false;
	}
}