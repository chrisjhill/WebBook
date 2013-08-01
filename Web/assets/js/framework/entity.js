/**
 * Handles the entity page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       27/07/2013
 */
WEBBOOK.Entity = {
	// Vars
	entitySelector:       ".entity",
	updateLinkSelector:   ".entity-update-link",
	saveLinkSelector:     "#entity-update",

	inputTitleSelector:   "#entity-title",
	inputImageSelector:   "#entity-image",
	inputContentSelector: "#entity-content",

	/**
	 * Set up the event listeners for the entities page.
	 *
	 * @listens Open entity on click
	 */
	init: function() {
		console.log(0);
		// Listeners
		$(document).on("click", this.entitySelector,   $.proxy(this.view,   this));
		$(document).on("click", this.saveLinkSelector, $.proxy(this.update, this));
	},

	/**
	 * Display the information on an entity.
	 *
	 * @param Event event
	 */
	view: function(event) {
		// Get the entity that we just clicked
		var $el = $(event.currentTarget);
		var entityId   = $el.data("entityid");
		var entityType = $el.data("entitytype");

		// Get the entity information
		$.ajax({
			url:  "/entity/get",
			type: "post",
			data: {
				book_id:   WEBBOOK.Book.bookId,
				entity_id: entityId,
				action:    "view"
			},
			success: function(data) {
				// Place the content at the top of the page, slide the old content
				// .. up, and slide the new content down.
				$(document).trigger({ type: "Modal_Show" }, {
					content:  data,
					class:    "modal-entity-view modal-" + entityType + "-view",
					entityId: entityId,
					callback: function(entityId) {
						$(WEBBOOK.Entity.updateLinkSelector).click(function() {
							WEBBOOK.Entity.updateView(entityId, entityType);
							return false;
						});
					}
				});
			}
		});

		return false;
	},

	/**
	 * Get and display the form form to update the entity.
	 *
	 * @param int    entityId   The ID of the entity that we want to update.
	 * @param string entityType The type of entity that we are working with.
	 */
	updateView: function(entityId, entityType) {
		$.ajax({
			url:  "/entity/get",
			type: "post",
			data: {
				book_id:   WEBBOOK.Book.bookId,
				entity_id: entityId,
				action:    "update"
			},
			success: function(data) {
				// Place the content at the top of the page, slide the old content
				// .. up, and slide the new content down.
				$(document).trigger({ type: "Modal_Show" }, {
					content:  data,
					class:    "modal-entity-view modal-" + entityType + "-update"
				});
			}
		});
	},

	/**
	 * User has clicked the save button.
	 *
	 * @param Event event
	 */
	update: function(event) {
		event.preventDefault();

		// Get the entity that we just clicked
		var $el = $(event.currentTarget);
		var entityId      = $el.data("entityid");
		var entityGroupId = $el.data("entitygroupid");
		var entityType    = $el.data("entitytype");

		$.ajax({
			url:  "/entity/update",
			type: "post",
			data: {
				book_id:         WEBBOOK.Book.bookId,
				entity_id:       entityId,
				entity_group_id: entityGroupId,
				entity_type:     entityType,
				entity_title:    $(this.inputTitleSelector).val(),
				entity_image:    $(this.inputImageSelector).val(),
				entity_content:  $(this.inputContentSelector).val()
			},
			success: function(data) {
				// Display the notice
				$(document).trigger({ type: "Notice" }, data);
			}
		});
	}
}