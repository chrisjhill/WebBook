/**
 * Handles interaction with the navigation element.
 *
 * Note: The Fullscreen link exists by default, but is hidden if the user does
 * not have WebKit.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       28/01/2013
 */
WEBBOOK.Nav = {
	// Vars
	navSelector:          "#navigation",
	navLinkSelector:      "a",
	fullscreenBgSelector: "#fullscreen-bg",
	contentSelector:      "#content",

	navHideAfterTime:     2000, // How long the navigation is visible before it starts to fade out.
	navFadeInTime:        200,  // How long it shoud take for the navigation to become visible.
	navFadeOutTime:       1000, // How long it should take for the navigation to completely fade.

	// DOM references
	$nav:     undefined,
	$navLink: undefined,
	$content: undefined,

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
		this.$content = $(this.contentSelector);

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
			.animate({opacity: "1"}, this.navFadeInTime);
	},

	/**
	 * The user has moused away from the navigation.
	 *
	 * @param Event event
	 */
	navigationLeave: function(event) {
		this.$nav.delay(this.navHideAfterTime)
			.animate({opacity: "0"}, this.navFadeOutTime);
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
	 * @todo   Move the pageStore into a content object.
	 * @todo   Use local storage instead of local variables, LS = persistence!
	 */
	navLinkClick: function(event) {
		// Set the action that we need to perform
		var action = event.currentTarget.hash.slice(1);

		// Fullscreen
		if (action == "fullscreen") {
			this.fullscreenToggle();
			return false;
		}

		// We need to load a new page
		// First, do we already have it in the page store?
		if (WEBBOOK.Content.has(action, false)) {
			this.$content.html(WEBBOOK.Content.get(action));
			return false;
		}

		// We need to get the page content and then save it
		$.ajax({
			url: "/" + action,
			success: function(data) {
				// Set the content
				WEBBOOK.Nav.$content.html(data);

				// And save the content
				$(document).trigger({ type: "Content_Retrieved" }, [action, data]);
			},
			error: function() {
				alert("Oh dear");
			}
		});

		return false;
	},

	/**
	 * Toggles fullscreen on and off.
	 *
	 * @triggers Fullscreen_Request
	 * @triggers Fullscreen_Cancel
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