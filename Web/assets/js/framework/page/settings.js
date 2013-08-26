/**
 * Handles the settings page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Settings = {
	// Vars
	updateSelector:         "#settings-save",

	settingAutosave:        "#setting_autosave",
	settingFontFamily:      "#setting_font_family",
	settingFontSize:        "#setting_font_size",
	settingFontColor:       "#setting_font_color",
	settingLineHeight:      "#setting_line_height",
	settingAlignment:       "#setting_alignment",
	settingBackground:      "#setting_background",
	settingPagePaddings:    "#setting_page_paddings",
	settingDisplayComments: "#setting_display_comments",

	customStylesSelector:   "#custom-styles",

	// DOM references
	$update:       undefined,
	$customStyles: undefined,

	/**
	 * Sets up the event listeners.
	 *
	 * @listens Update On Click
	 */
	init: function() {
		// Set DOM references
		this.$update       = $(this.updateSelector);
		this.$customStyles = $(this.customStylesSelector);

		// Listeners
		this.$update.on("click", $.proxy(this.update, this));
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
			url:  "/settings/update",
			type: "post",
			data: {
				book_id:                  WEBBOOK.Book.bookId,
				setting_autosave:         $(this.settingAutosave).val(),
				setting_font_family:      $(this.settingFontFamily).val(),
				setting_font_size:        $(this.settingFontSize).val(),
				setting_font_color:       $(this.settingFontColor).val(),
				setting_line_height:      $(this.settingLineHeight).val(),
				setting_alignment:        $(this.settingAlignment).val(),
				setting_background:       $(this.settingBackground).val(),
				setting_page_paddings:    $(this.settingPagePaddings).val(),
				setting_display_comments: $(this.settingDisplayComments).val()
			},
			success: function(data) {
				// Save the content
				$(document).trigger({ type: "Content_Update" }, "settings");

				// Display the notice
				$(document).trigger({ type: "Notice" }, data);

				// Reload the stylesheet
				var customStyle = WEBBOOK.Settings.$customStyles.attr("href");
				customStyle = customStyle.split("?");
				WEBBOOK.Settings.$customStyles.attr(
					"href",
					customStyle[0] + "?time=" + new Date().getTime()
				);
			}
		});

		return false;
	}
}

WEBBOOK.Settings.init();