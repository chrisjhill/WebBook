/**
 * Handles editing of text, creating new chapters and sections.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Section = {
	// Vars
	sectionsSelector:       ".section",
	// Updating content
	sectionsUpdateInterval: 1000,
	sectionsUpdated:        [],
	// Inserting new subtitles, content, and removing section
	sectionHandlerSelector:           "#section-handler",
	sectionHandlerSectionsSelector:   ".chapter-title,.content,.subtitle",
	sectionHandlerAddTitleSelector:   "#section-handler-title",
	sectionHandlerAddContentSelector: "#section-handler-content",
	sectionHandlerDeleteSelector:     "#section-handler-delete",

	// DOM references
	$section:        undefined,
	$sectionHandler: undefined,

	/**
	 * Listen for updates to the text, and adding of new chapters and sections.
	 *
	 * @listens SectionHandler_AddTitle   On Click        Adds a title to chapter.
	 * @listens SectionHandler_AddContent On Click        Adds a content to chapter.
	 * @listens SectionHandler_Delete     On Click        Deletes the section.
	 *
	 * @listens Chapter_Section           On Keyup, Paste Updates section content.
	 * @listens SectionHandler            On MouseEnter   Shows the section handler.
	 *
	 * @listens Section_Inserted, Section_Deleted         Close the section handler.
	 * @listens Section_Inserted, Section_Deleted         Reindex the sections.
	 */
	init: function() {
		// Set DOM references
		this.$section        = $(this.sectionsSelector);
		this.$sectionHandler = $(this.sectionHandlerSelector);

		// Listeners
		this.$sectionHandler.on("click", this.sectionHandlerAddTitleSelector,   $.proxy(this.insertSubtitle, this));
		this.$sectionHandler.on("click", this.sectionHandlerAddContentSelector, $.proxy(this.insertContent,  this));
		this.$sectionHandler.on("click", this.sectionHandlerDeleteSelector,     $.proxy(this.delete,         this));

		// Listeners (External)
		WEBBOOK.Book.$book.on("keyup paste", this.sectionsSelector,               $.proxy(this.updated,     this));
		WEBBOOK.Book.$book.on("mouseenter",  this.sectionHandlerSectionsSelector, $.proxy(this.handlerOpen, this));

		// Listeners (via triggers)
		$(document).on("Section_Inserted Section_Deleted", $.proxy(this.handlerClose,   this));
		$(document).on("Section_Inserted Section_Deleted", $.proxy(this.sectionReindex, this));

		// Save the content every x seconds
		setInterval(function() {
			WEBBOOK.Section.update();
		}, this.sectionsUpdateInterval);
	},

	/**
	 * A section has been inserted or deleted, reindex the sections.
	 *
	 * @param Event e
	 */
	sectionReindex: function(e) {
		this.$section = $(this.sectionsSelector);
	},

	/**
	 * The user has updated a section in some way.
	 *
	 * @param Event e
	 */
	updated: function(e) {
		console.log("Updated");
		this.sectionsUpdated[$(e.currentTarget).data("sectionid")] = $(e.currentTarget);
	},

	/**
	 * Save the modifications that have been made to the sections.
	 *
	 */
	update: function() {
		// Are there any changes to save?
		if (this.sectionsUpdated.length <= 0) {
			return false;
		}

		// There are sections to save
		// Loop over and update
		for (sectionId in this.sectionsUpdated) {
			// Reference to the section
			$.ajax({
				url:  "/section/update",
				type: "post",
				data: {
					book_id:         WEBBOOK.Book.bookId,
					section_id:      this.sectionsUpdated[sectionId].data("sectionid"),
					section_order:   this.sectionsUpdated[sectionId].data("order"),
					section_content: this.sectionsUpdated[sectionId].html(),
				}
			});
		}

		// And reset
		this.sectionsUpdated = [];
	},

	/**
	 * The user has hovered over a section that can be "handled".
	 *
	 * This means we can add a new subtitle or content section after this section,
	 * and we can also delete this section.
	 *
	 * Note: This only opens for subtitles and content blocks, since everything
	 * else is required and cannot de deleted.
	 *
	 * @param Event e
	 */
	handlerOpen: function(e) {
		// Place the section into a variable for speed
		var $el = $(e.currentTarget);

		// If it is a chapter title then do not allow them to delete the section
		if ($el.hasClass("chapter-title")) {
			$(this.sectionHandlerDeleteSelector).hide();
		} else {
			$(this.sectionHandlerDeleteSelector).show();
		}

		// We want to display the handler in different positions depending if the
		// .. section is a subtitle or a cpontent block. This is because a
		// .. content block can stretch for quite a long way, so makes more sense
		// .. to display it where the mouse enters.
		var offset     = $el.offset();
		var offsetTop  = parseInt(offset.top)  + 8;
		var offsetLeft = parseInt(offset.left) - 70;

		// If this is a content section then it is a little more tricky than
		// .. subtitles. We need to make sure we do not place the handler above
		// .. or below the content.
		if ($el.hasClass("content")) {
			var offsetTopMax = offsetTop + parseInt($el.height()) - 58;
			offsetTop = parseInt(e.pageY) + 2;

			// Would we be showing the handler below the content?
			if (offsetTop > offsetTopMax) {
				offsetTop = offsetTopMax;
			}
		}

		// And show the handler
		this.$sectionHandler
			.hide()
			.data("sectionid", $el.data("sectionid"))
			.css({ top: offsetTop + "px", left: offsetLeft + "px" })
			.fadeIn(750);
	},

	/**
	 * Close the section handler.
	 *
	 */
	handlerClose: function() {
		this.$sectionHandler.stop(true, true).fadeOut(250);
	},

	/**
	 * Insert a title into this chapter.
	 *
	 * @param Event e
	 */
	insertSubtitle: function(e) {
		this.insert("subtitle");
		return false;
	},

	/**
	 * Insert a content block into this chapter.
	 *
	 * @param Event e
	 */
	insertContent: function(e) {
		this.insert("content");
		return false;
	},

	/**
	 * Insert a new section.
	 *
	 * @param string sectionType The type of section we want to insert.
	 *
	 * @triggers Section_Inserted If we managed to insert the section.
	 */
	insert: function(sectionType) {
		// The section we need to insert this section after
		var sectionId = this.$sectionHandler.data("sectionid");

		// Get the section DOM element
		var $el = this.$section.filter("#section-" + sectionId);

		// The order of the new section
		var sectionOrder = parseInt($el.data("order")) + 1;

		// Increment the sections *after* this new section will be added
		this.$section.filter(function() {
			if (parseInt($(this).data("order")) >= sectionOrder) {
				$(this).data().order++;
			};
		});

		// Insert the section via Ajax
		$.ajax({
			url:  "/section/insert",
			type: "post",
			data: {
				book_id:      WEBBOOK.Book.bookId,
				chapter_id:   $el.data("chapterid"),
				section_type: sectionType,
				order:        sectionOrder
			},
			success: function(data) {
				// Set the content
				$el.after(data).next(WEBBOOK.Section.sectionsSelector)
					.focus()
					.animate({ backgroundColor: "#FFFFAA" }, 750)
					.animate({ backgroundColor: "#FFFFFF" }, 2000);

				// Select the content to save the user a couple keystrokes
				 document.execCommand("selectAll", false, null);

				// Let others know what just happened
				$(document).trigger({ type: "Section_Inserted" }, [sectionId]);
			},
			error: function() {
				alert("Sorry, we were unable to load the page :(");
			}
		});
	},

	/**
	 * Delete a section from this book.
	 *
	 * @param Event e
	 *
	 * @triggers Section_Deleted If we managed to deleted the section.
	 * @triggers Notice          If we try and remove a chapter title.
	 */
	delete: function(e) {
		// The section we need to insert this section after
		var sectionId = this.$sectionHandler.data("sectionid");

		// Get the section DOM element
		var $el = this.$section.filter("#section-" + sectionId);

		// Do not allow deletion of chapter titles
		// @todo This needs to be made into a proper Notice trigger
		if ($el.hasClass("chapter-title")) {
			$(document).trigger({ type: "Notice" },
				'<p class="notice notice-error">'
					+ '<strong>Sorry, you cannot remove chapter titles</strong>'
					+ '</p>');
			return false;
		}

		// The order of the new section
		var sectionOrder = parseInt($el.data("order"));

		// Decrement the sections *after* this section
		this.$section.filter(function() {
			if (parseInt($(this).data("order")) <= sectionOrder) {
				$(this).data().order--;
			};
		});

		// Insert the section via Ajax
		$.ajax({
			url:  "/section/delete",
			type: "post",
			data: {
				book_id:       WEBBOOK.Book.bookId,
				chapter_id:    $el.data("chapterid"),
				section_id:    sectionId,
				section_order: sectionOrder
			},
			success: function(data) {
				// Remove the section from the DOM
				$el.animate({ height: 0, opacity: 0 }, 250, function() {
					$(this).remove();
				});

				// Let others know what just happened
				$(document).trigger({ type: "Section_Deleted" }, [sectionId]);
			},
			error: function() {
				alert("Sorry, we were unable to load the page :(");
			}
		});

		return false;
	}
}