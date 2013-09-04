/**
 * Handles the entity page.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       27/07/2013
 */
WEBBOOK.EntityGroup = {
	// Vars
	updateSelector: ".entity-group-update",

	titleSelector:  "#group-title",
	saveSelector:   "#entity-group-update",

	/**
	 * Set up the event listeners for the entities page.
	 *
	 * @listens View   entity on click
	 * @listens Update entity on click
	 */
	init: function() {
		// Listeners
		$(document).on("click", this.updateSelector, $.proxy(this.view,   this));
		$(document).on("click", this.saveSelector,   $.proxy(this.update, this));
	},

	/**
	 * Display the update group view.
	 *
	 * @param Event event
	 */
	view: function(event) {
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
	},

	/**
	 * Update an entity group.
	 *
	 * @param Event event
	 */
	update: function(event) {
		event.preventDefault();

		// Get the entity that we just clicked
		var $el = $(event.currentTarget);
		var entityGroupId = $el.data("entitygroupid");

		// Get the group information and display in modal
		$.ajax({
			url:  "/entity/group-update",
			type: "post",
			data: {
				book_id:         WEBBOOK.Book.bookId,
				entity_group_id: entityGroupId,
				group_title:     $(this.titleSelector).val()
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
}