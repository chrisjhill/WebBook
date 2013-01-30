/**
 * Handles interaction with the navigation element.
 *
 */
WEBBOOK.Fullscreen = {
	// Vars
	fullscreenBgSelector: "#fullscreen-bg",

	fullscreenBgLapse:    5000, // How many microseconds before we re-evaluate the height

	// DOM references
	$fullscreenBg: undefined,

	/**
	 * Sets up the fullscreen background and waits for triggers.
	 *
	 * @listens FullscreenBg On Fullscreen_Request
	 * @listens FullscreenBg On Fullscreen_Cancel
	 */
	init: function() {
		// Set DOM references
		this.$fullscreenBg = $(this.fullscreenBgSelector);

		// Listeners
		$(document)
			.on("Fullscreen_Request", $.proxy(this.fullscreenRequest, this))
			.on("Fullscreen_Cancel",  $.proxy(this.fullfullscreenCancelscreenRequest, this));

		// And set the height of the fullscreen background every so often
		setInterval(function() {
			WEBBOOK.Fullscreen.fullscreenHeight()
		}, this.fullscreenBgLapse);
	},

	/**
	 * Make the height of the fullscreen backgound the same as the document.
	 *
	 * We do this because the body background will dissapear. We need to
	 * continue running this function because it will be constantly updated
	 * by the user.
	 */
	fullscreenHeight: function() {
		this.$fullscreenBg.height(
			parseInt($(document).height() + 500) + "px"
		);
	},

	/**
	 * Make the website fullscreen.
	 *
	 * @param Event event
	 */
	fullscreenRequest: function(event) {
		document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
	},

	/**
	 * Close the fullscreen.
	 *
	 * @param Event event
	 */
	fullscreenCancel: function(event) {
		document.documentElement.webkitCancelFullScreen();
	}
}