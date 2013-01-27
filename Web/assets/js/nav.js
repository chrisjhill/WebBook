/**
 * Handles interaction with the navigation element.
 *
 */
WEBBOOK.Nav = {
	// Vars
	navSelector:      "#navigation",
	navHideAfterTime: 2000, // How long the navigation is visible before it starts to fade out.
	navFadeInTime:    200,  // How long it shoud take for the navigation to become visible.
	navFadeOutTime:   1000, // How long it should take for the navigation to completely fade.

	// DOM references
	$nav: undefined,

	/**
	 * Sets up the navigation.
	 *
	 * @listens Nav On MouseEnter
	 * @listens Nav On MouseLeave
	 */
	init: function() {
		this.$nav = $(this.navSelector);

		this.$nav.delay(this.navHideAfterTime).animate({opacity: 0}, this.navFadeOutTime)
			.on("mouseenter", $.proxy(this.navigationEnter, this))
			.on("mouseleave", $.proxy(this.navigationLeave, this));
	},

	/**
	 * The user has hovered over the navigation.
	 *
	 * @param Event event
	 */
	navigationEnter: function(event) {
		this.$nav.stop(true)
			.animate({opacity: '1'}, this.navFadeInTime);
	},

	/**
	 * The user has moused away from the navigation.
	 *
	 * @param Event event
	 */
	navigationLeave: function(event) {
		this.$nav.delay(this.navHideAfterTime)
			.animate({opacity: '0'}, this.navFadeOutTime);
	}
};