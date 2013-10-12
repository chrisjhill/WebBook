/**
 * Handles opening and closing a modal window.
 *
 * @copyright   2013 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       29/07/2013
 */
WEBBOOK.Modal = {
	// Vars
	modalSelector:         "#modal",
	modalCloseSelector:    "#modal-close",
	modalContentSelector:  "#modal-content",

	modalBackdropSelector: "#modal-backdrop",

	modalOpenClass:        "modal-open",      // Applied to the body

	// DOM references
	$modal:         undefined,
	$modalBackdrop: undefined,

	/**
	 * Listens for openings and closings.
	 *
	 * @listens Document   On Modal_Show
	 * @listens Document   On Modal_Hide
	 * @listens ModalClose On Click
	 */
	init: function() {
		// Set DOM references
		this.$modal         = $(this.modalSelector);
		this.$modalBackdrop = $(this.modalBackdropSelector);

		// Listeners
		$(document).on("Modal_Show",                     $.proxy(this.show, this));
		$(document).on("Modal_Hide",                     $.proxy(this.hide, this));
		this.$modal.on("click", this.modalCloseSelector, $.proxy(this.hide, this));
		this.$modalBackdrop.on("click",                  $.proxy(this.hide, this));
	},

	/**
	 * Places the content into the modal and opens.
	 *
	 * {
	 *     content:        "The content for the modal window",
	 *     class:          "modal-class-name",
	 *     callback:       function(data.callbackParams) { ... },
	 *     callbackParams: { ... }
	 * }
	 *
	 * @param Event  event
	 * @param string data  The content and class for the modal.
	 */
	show: function(event, data) {
		// Add the custom class to the modal window and replace the content
		this.$modal
			.attr("class", data.class)
			.find(this.modalContentSelector)
			.html(data.content);

		// Show the modal
		$("body").addClass(this.modalOpenClass);

		// If there is a callback then fire it up
		if (typeof data.callback !== "undefined") {
			data.callback(data.callbackParams);
		}
	},

	hide: function(event) {
		event.preventDefault();
		$("body").removeClass(this.modalOpenClass);
	}
}