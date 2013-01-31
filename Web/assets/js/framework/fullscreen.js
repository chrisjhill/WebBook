/**
 * Handles interaction with the navigation element.
 *
 * At the moment we only support WebKit since they are the only browser which
 * supports fullscreen scrolling. Gecko is making this possible but is, at the
 * moment of writing, not available. As soon as it does then it will be added.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       30/01/2013
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