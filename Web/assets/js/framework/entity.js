/**
 * Handles the entity page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       27/07/2013
 */
WEBBOOK.Entity = {
	// Vars
	insertSelector:       ".entity-insert",
	insertLinkSelector:   "#entity-insert-link",
	entitySelector:       ".entity",
	updateLinkSelector:   ".entity-update-link",
	saveLinkSelector:     "#entity-update",
	deleteLinkSelector:   ".entity-delete-link",
	groupUpdateSelector:  ".entity-group-update",

	inputTitleSelector:   "#entity-title",
	inputImageSelector:   "#entity-image",
	inputContentSelector: "#entity-content",

	/**
	 * Set up the event listeners for the entities page.
	 *
	 * @listens Insert entity on click
	 * @listens Open   entity on click
	 * @listens Save   entity on click
	 */
	init: function() {
		// Listeners
		$(document).on("click", this.insertSelector,      $.proxy(this.insertView, this));
		$(document).on("click", this.entitySelector,      $.proxy(this.view,       this));
		$(document).on("click", this.saveLinkSelector,    $.proxy(this.update,     this));
		$(document).on("click", this.deleteLinkSelector,  $.proxy(this.delete,     this));
		$(document).on("click", this.groupUpdateSelector, $.proxy(this.groupView,  this));
	},

	/**
	 * Bring up the insert entity modal window.
	 *
	 * @param Event event
	 */
	insertView: function(event) {
		// Get the group information that we want to insert this to
		var $el = $(event.currentTarget);
		var entityGroupId = $el.data("entitygroupid");
		var entityType    = $el.data("entitytype");

		// Get the data for the modal
		$.ajax({
			url:  "/entity/insert-view",
			type: "post",
			data: {
				book_id:         WEBBOOK.Book.bookId,
				entity_group_id: entityGroupId,
				entity_type:     entityType
			},
			success: function(data) {
				$(document).trigger({ type: "Modal_Show" }, {
					content:  data,
					class:    "modal-entity-insert",
					entityId: entityGroupId,
					callback: function(entityId) {
						$(WEBBOOK.Entity.insertLinkSelector).click(function(event) {
							event.preventDefault();
							WEBBOOK.Entity.insert(entityGroupId, entityType);
						});
					}
				});
			}
		});

		return false;
	},

	/**
	 * Insert an entity into the database.
	 *
	 * @param  int    entityGroupId The ID of the group to insert this entity.
	 * @param  string entityType    The type of entity we are inserting.
	 */
	insert: function(entityGroupId, entityType) {
		$.ajax({
			url:  "/entity/insert",
			type: "post",
			data: {
				book_id:         WEBBOOK.Book.bookId,
				entity_group_id: entityGroupId,
				entity_type:     entityType,
				entity_title:    $("#entity-title").val(),
				entity_image:    $("#entity-image").val(),
				entity_content:  $("#entity-content").val()
			},
			success: function(data) {
				$(document)
					.trigger({ type: "Notice"      }, data)
					.trigger({ type: "Modal_Hide"  })
					.trigger({ type: "Reload_View" });
			}
		});
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
				$(document).trigger({ type: "Modal_Show" }, {
					content:  data,
					class:    "modal-entity-view modal-" + entityType + "-view",
					entityId: entityId,
					callback: function(entityId) {
						$(WEBBOOK.Entity.updateLinkSelector).click(function(event) {
							event.preventDefault();
							WEBBOOK.Entity.updateView(entityId, entityType);
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
	},

	/**
	 * Delete an entity.
	 *
	 * @param Event event
	 */
	delete: function(event) {
		event.preventDefault();

		// Get the entity that we just clicked
		var $el = $(event.currentTarget);
		var entityId      = $el.data("entityid");
		var entityType    = $el.data("entitytype");

		// Make sure the user knows what they are doing
		if (confirm("Are you sure you wish to delete this?")) {
			$.ajax({
				url:  "/entity/remove",
				type: "post",
				data: {
					book_id:     WEBBOOK.Book.bookId,
					entity_id:   entityId,
					entity_type: entityType
				},
				success: function(data) {
					// Display the notice
					$(document)
						.trigger({ type: "Notice"      }, data)
						.trigger({ type: "Modal_Hide"  })
						.trigger({ type: "Reload_View" });
				}
			});
		}
	},

	/**
	 * Display the update group view.
	 *
	 * @param Event event
	 */
	groupView: function(event) {
		event.preventDefault();

		// Get the entity that we just clicked
		var $el = $(event.currentTarget);
		var entityGroupId = $el.data("entitygroupid");

		// Get the group information and display in modal
		$.ajax({
			url:  "/entity/group",
			type: "post",
			data: {
				book_id:         WEBBOOK.Book.bookId,
				entity_group_id: entityGroupId
			},
			success: function(data) {
				$(document).trigger({ type: "Modal_Show" }, {
					content:  data,
					class:    "modal-group-entity-view"
				});
			}
		});
	}
}