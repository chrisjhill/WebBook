/**
 * Allows the user to customise some of the text they are writing.
 *
 * We do not want the user to spend too long worrying about formatting. Instead
 * we want them to write! Due to this we do not give them that many options.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       28/01/2013
 */
WEBBOOK.Wysiwyg = {
	// Vars
	sectionSelector:     ".section",
	wysiwygSelector:     "#wysiwyg",
	wysiwygItemSelector: ".wysiwyg-item",

	// DOM references
	$section:     undefined,
	$wysiwyg:     undefined,
	$wysiwygItem: undefined,

	/**
	 * Sets up the WYSIWYG editor.
	 *
	 * @listens Section     On MouseUp and Update
	 * @listens WysiwygItem On CLick
	 */
	init: function() {
		this.$section     = $(this.sectionSelector);
		this.$wysiwyg     = $(this.wysiwygSelector);
		this.$wysiwygItem = $(this.wysiwygItemSelector);

		this.$section.on("mouseup update", $.proxy(this.hideShowWysiwyg,    this));
		this.$wysiwygItem.on("click",      $.proxy(this.wysiwygItemClicked, this));
	},

	/**
	 * Hide or show the WYSIWYG editor.
	 *
	 * There are several commands that we support:
	 *
	 * <ul>
	 *     <li>Bold</li>
	 *     <li>Italic</li>
	 *     <li>Underline</li>
	 *     <li>backColor</li>
	 *     <li>removeFormat</li>
	 * </ul>
	 *
	 * @param Event event
	 * @todo  There is a bug with WebKit where removeFormat does not remove backColor.
	 */
	hideShowWysiwyg: function(event) {
		// Get the range
		var range = this.getRange();

		// Do we need to show the WYSIWYG?
		if (range[0] !== range[1]) {
			// Show the editor
			this.$wysiwyg.css({
				top:  (parseInt(event.clientY) + 20)  + "px",
				left: (parseInt(event.clientX) - 125) + "px"
			}).fadeIn(250);
		} else {
			// Hide the editor
			this.$wysiwyg.hide();
		}
	},

	/**
	 * A WYSIWYG item has been clicked.
	 *
	 * @param Event event
	 */
	wysiwygItemClicked: function(event) {
		document.execCommand(
			event.currentTarget.dataset.cmd,
			null,
			(event.currentTarget.dataset.cmd == "backColor" ? "#FEEFB3" : "")
		);
	},

	/**
	 * Return the range of the the selected text.
	 *
	 * @return array
	 */
	getRange: function() {
		if (window.getSelection) {
			// Non-IE
			var savedRange = window.getSelection().getRangeAt(0);
		} else if (document.selection) {
			// IE
			var savedRange = document.selection.createRange();
		}

		return [savedRange.startOffset, savedRange.endOffset];
	}
};