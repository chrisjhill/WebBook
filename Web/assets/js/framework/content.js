/**
 * Handles page content.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Content = {
	/**
	 * Listens for content updates.
	 *
	 * @listens Document On Content_Retrieved
	 * @listens Document On Content_Update
	 */
	init: function() {
		$(document)
			.on("Content_Retrieved", function(event, page, content) {
				WEBBOOK.Content.save(event, page, content);
			})
			.on("Content_Update", function(event, page, content) {
				WEBBOOK.Content.save(event, page, content);
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
	save: function(event, page, content) {
		WEBBOOK.Store.put("content." + page, content);
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