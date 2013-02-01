/**
 * Handles page content.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Content = {
	// Vars
	contentSelector: "#content",

	// DOM references
	$content: undefined,

	/**
	 * Listens for content updates.
	 *
	 * @listens Document On Content_Retrieved
	 * @listens Document On Content_Update
	 */
	init: function() {
		// Set DOM references
		this.$content = $(this.contentSelector);

		// Listeners
		$(document)
			.on("Content_Retrieved", function(event, page, content) {
				WEBBOOK.Content.save(page, content);
			})
			.on("Content_Update", function(event, page) {
				WEBBOOK.Content.update(page);
			});
	},

	/**
	 * Returns boolean if the page exists in our cache.
	 *
	 * @param string page The page name that we want to see if we have cached.
	 */
	has: function(page) {
		return WEBBOOK.Store.has("content." + page);
	},

	/**
	 * Saves the content for access later on.
	 *
	 * @param string page    The page name that we want to save.
	 * @param string content The page's HTML.
	 */
	save: function(page, content) {
		WEBBOOK.Store.put("content." + page, content);
	},

	/**
	 * This function places the content retrieval in one place.
	 *
	 * @param Event  event
	 * @param string page  The page name that we want to save.
	 *
	 * @todo I don't think html() will work here, might need some other skullduggery.
	 */
	update: function(event, page) {
		WEBBOOK.Content.save(page, this.$content.html());
	},

	/**
	 * Returns the page content.
	 *
	 * @param string page The page name of the content we want to return.
	 */
	get: function(page) {
		return WEBBOOK.Store.get("content." + page, false);
	}
}