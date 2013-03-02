/**
 * Handles editing of text, creating new chapters and sections.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Edit = {
	// Vars
	sectionsSelector:       ".section",

	sectionsUpdateInterval: 5000,
	sectionsModified:       [],

	// DOM references
	$section: undefined,

	/**
	 * Listen for updates to the text, and adding of new chapters and sections.
	 *
	 * @listens Section On Focus, Blur, Keyup, Paste
	 */
	init: function() {
		// Set DOM references
		this.$section = $(this.sectionsSelector);

		// Listeners
		this.$section.on("keyup paste", $.proxy(this.sectionModified, this));

		// Save the content every x seconds
		setInterval(function() {
			WEBBOOK.Edit.saveModifications();
		}, this.sectionsUpdateInterval);
	},

	/**
	 * The user has modified a section in some way.
	 *
	 * @param Event e
	 */
	sectionModified: function(e) {
		this.sectionsModified[$(e.currentTarget).data("sectionid")] = $(e.currentTarget);
	},

	/**
	 * Save the modifications that have been made to the sections.
	 *
	 */
	saveModifications: function() {
		// Are there any changes to save?
		if (this.sectionsModified.length <= 0) {
			return false;
		}

		// There are sections to save
		// Loop over and update
		for (sectionId in this.sectionsModified) {
			// Reference to the section
			$.ajax({
				url:  "/section/update",
				type: "post",
				data: {
					section_id:      this.sectionsModified[sectionId].data("sectionid"),
					section_order:   this.sectionsModified[sectionId].data("order"),
					section_content: this.sectionsModified[sectionId].html(),
				}
			});
		}

		// And reset
		this.sectionsModified = [];
	}
}