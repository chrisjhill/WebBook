/**
 * Handles interaction with the navigation element.
 *
 */
WEBBOOK.Nav = {
	// Vars
	navSelector:          "#navigation",
	navLinkSelector:      "a",
	fullscreenBgSelector: "#fullscreen-bg",

	navHideAfterTime:     2000, // How long the navigation is visible before it starts to fade out.
	navFadeInTime:        200,  // How long it shoud take for the navigation to become visible.
	navFadeOutTime:       1000, // How long it should take for the navigation to completely fade.

	// DOM references
	$nav:     undefined,
	$navLink: undefined,

	/**
	 * Sets up the navigation.
	 *
	 * @listens Nav      On MouseEnter
	 * @listens Nav      On MouseLeave
	 * @listens NavLinks On Click
	 */
	init: function() {
		// Set DOM references
		this.$nav     = $(this.navSelector);
		this.$navLink = this.$nav.find(this.navLinkSelector);

		// Listeners
		this.$nav.delay(this.navHideAfterTime).animate({opacity: 0}, this.navFadeOutTime)
			.on("mouseenter", $.proxy(this.navigationEnter, this))
			.on("mouseleave", $.proxy(this.navigationLeave, this));

		this.$navLink.on("click", $.proxy(this.navLinkClick, this));

		// Only Webkit supports fullscreen to a satisfactory level
		// People with Firefox can go View > Fullscreen
		if (! document.documentElement.webkitRequestFullScreen) {
			$(this.navSelector).find(this.navLinkSelector + "[href='#fullscreen']").parent().hide();
		}
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
	},

	/**
	 * The user has clicked a navigational item.
	 *
	 * We store the result of each page in the users local storage to save
	 * going to the server everytime. This will speed up their interaction.
	 *
	 * We also have a special use case with the fullscreen link. It takes
	 * the user nowhere, we intercept it here and go fullscreen.
	 *
	 * @param  Event   event
	 * @return boolean
	 */
	navLinkClick: function(event) {
		// Set the action that we need to perform
		var action = event.currentTarget.hash.slice(1);

		// Fullscreen
		if (action == 'fullscreen') {
			this.fullscreenToggle();
			return false;
		}

		// @todo Functionality for loading new pages asynchronously.

		return false;
	},

	/**
	 * Toggles fullscreen on and off.
	 *
	 */
	fullscreenToggle: function() {
		// We are not yet fullscreen
		if (! document.documentElement.webkitFullScreen) {
			$(document).trigger({ type: "Fullscreen_Request" });
		}

		// We are already in fullscreen mode, close
		else {
			$(document).trigger({ type: "Fullscreen_Cancel" });
		}
	}
};