/**
 * Handles the character page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       27/07/2013
 */
WEBBOOK.Character = {
	// Vars
	characterSelector: ".character",

	// DOM references
	$character: undefined,

	/**
	 * Set up the event listeners for the characters page.
	 *
	 * @listens Open character on click
	 */
	init: function() {
		// Set DOM references
		this.$character = $(this.characterSelector);

		// Listeners
		this.$character.on("click", $.proxy(this.view, this));
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

		// Do something here

		return false;
	}
}

WEBBOOK.Character.init();