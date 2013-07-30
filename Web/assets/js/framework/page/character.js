/**
 * Handles the character page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       27/07/2013
 */
WEBBOOK.Character = {
	// Vars
	characterSelector:  ".character",
	updateLinkSelector: ".entity-update-link",

	/**
	 * Set up the event listeners for the characters page.
	 *
	 * @listens Open character on click
	 */
	init: function() {
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
				$(document).trigger({ type: "Modal_Show" }, {
					content:  data,
					class:    "modal-character-view",
					entityId: characterId,
					callback: function(entityId) {
						$(WEBBOOK.Character.updateLinkSelector).click(function() {
							WEBBOOK.Character.updateView(characterId);
							return false;
						});
					}
				});
			}
		});

		return false;
	},

	/**
	 * Get and display the form form to update the character.
	 *
	 * @param int characterId The ID of the character that we want to update.
	 */
	updateView: function(characterId) {
		$.ajax({
			url:  "/entity/get",
			type: "post",
			data: {
				book_id:   WEBBOOK.Book.bookId,
				entity_id: characterId,
				action:    "update"
			},
			success: function(data) {
				// Place the content at the top of the page, slide the old content
				// .. up, and slide the new content down.
				$(document).trigger({ type: "Modal_Show" }, {
					content:  data,
					class:    "modal-character-update"
				});
			}
		});
	}
}

WEBBOOK.Character.init();