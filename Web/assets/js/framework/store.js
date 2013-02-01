/**
 * Handles storing content.
 *
 * We will use LocalStorage if we can as it will persist. If not then we
 * will fall back to saving it per request in a storage variable.
 *
 * This object will store all of the "bits and bobs" that need to be
 * retained. In general, objects should namespace each of the variables.
 * So, WEBBOOK.Content will set variables as content.xyz
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       01/02/2013
 */
WEBBOOK.Store = {
	// Vars
	store: {},
	localStorageAvailable: false,

	/**
	 * Sets up the object and ascertains whether we can use localstorage.
	 *
	 */
	init: function() {
		// Can we use LocalStorage?
		if (localStorage) {
			this.localStorageAvailable = true;
		}
	},

	/**
	 * Returns boolean if the variable exists in the store.
	 *
	 * @param  string  variable The variable name.
	 * @return boolean
	 */
	has: function(variable) {
		if (this.localStorageAvailable) {
			return typeof localStorage[variable] !== "undefined";
		} else {
			return typeof this.store[variable]   !== "undefined";
		}
	},

	/**
	 * Save the variable.
	 *
	 * @param string variable The variable name.
	 * @param string content  The value to assign the variable.
	 */
	put: function(variable, value) {
		if (this.localStorageAvailable) {
			localStorage[variable] = value;
		} else {
			this.store[variable]   = value;
		}
	},

	/**
	 * Get something that has been saved in the store.
	 *
	 * @param  string variable     The variable name.
	 * @param  string defaultValue If the variable is not in the store then this will be returned.
	 * @return mixed
	 */
	get: function(variable, defaultValue) {
		if (this.localStorageAvailable) {
			return this.has(variable)
				? localStorage[variable]
				: defaultValue;
		} else {
			return this.has(variable)
				? this.store[variable]
				: defaultValue;
		}
	}
}