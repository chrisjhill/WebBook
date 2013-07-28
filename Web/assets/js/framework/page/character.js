/**
 * Handles the character page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       27/07/2013
 */
WEBBOOK.Character = {
	// Vars
	charactersExtraSelector: "#characters-extra",
	charactersSelector:      "#characters",
	characterSelector:       ".character",

	// DOM references
	$charactersExtra: undefined,
	$characters:      undefined,

	/**
	 * Set up the event listeners for the characters page.
	 *
	 * @listens Open character on click
	 */
	init: function() {
		// Set DOM references
		this.$charactersExtra = $(this.charactersExtraSelector);
		this.$characters      = $(this.charactersSelector);

		// Listeners
		$(document).on("click", this.characterSelector, $.proxy(this.view, this));
	},

	/**
	 * Display the information on a character.
	 *
	 * @param  Event event
	 */
	view: function(event) {
		// Get the character that we just clicked
		var $el = $(event.currentTarget);
		var characterId = $el.data("entityid");

		// Get the character information
		$.ajax({
			url:  "/entity/get",
			type: "post",
			data: {
				book_id:   WEBBOOK.Book.bookId,
				entity_id: characterId,
				action:    "view"
			},
			success: function(data) {
				// Place the content at the top of the page, slide the old content
				// .. up, and slide the new content down.
				$(WEBBOOK.Character.charactersExtraSelector).html(data).slideDown();
				$(WEBBOOK.Character.charactersSelector).slideUp();
			}
		});

		return false;
	}
}

WEBBOOK.Character.init();