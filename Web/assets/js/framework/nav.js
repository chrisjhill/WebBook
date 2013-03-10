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

	pagesLoaded:          {},   // Keeps track of which pages have been loaded in this session.

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
	 *
	 * @triggers Content_Retrieved If our Ajax function succeeded.
	 */
	navLinkClick: function(event) {
		// Set the page that we need to load
		var page = event.currentTarget.hash.slice(1);

		// Fullscreen
		if (page == "fullscreen") {
			this.fullscreenToggle();
			return false;
		}

		// We need to load a new page
		// First, do we already have it in the page store?
		if (WEBBOOK.Content.has(page, false)) {
			this.$content.html(WEBBOOK.Content.get(page));
			this.loadJavascript(page);
			return false;
		}

		// We need to get the page content and then save it
		$.ajax({
			url: "/" + page,
			success: function(data) {
				// Set the content
				WEBBOOK.Nav.$content.html(data);
				WEBBOOK.Nav.loadJavascript(page);

				// And save the content
				$(document).trigger({ type: "Content_Retrieved" }, [page, data]);
			},
			error: function() {
				alert("Sorry, we were unable to load the page :(");
			}
		});

		return false;
	},

	/**
	 * Loads a page's Javascript as and when required.
	 *
	 * We do not want to load every single JavaScript snippet when a user first
	 * lands on the page. Instead we will gradually load it as they navigate,
	 * saving both time for the user and bandwidth.
	 *
	 * @param string page The page we wish to load
	 */
	loadJavascript: function(page) {
		if (typeof this.pagesLoaded[page] === "undefined") {
			$.getScript("/assets/js/framework/page/" + page + ".js");

			this.pagesLoaded[page] = true;
		}
	},

	/**
	 * Toggles fullscreen on and off.
	 *
	 * @triggers Fullscreen_Request If we need to go fullscreen.
	 * @triggers Fullscreen_Cancel  If we need to cancel fullscreen.
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