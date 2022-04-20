/*
 * Google Analytics by WEBKINDER
 * Admin JS Functions
 */

var WKGA_AdminFunctions = {
  CookieName: "wp_wk_ga_untrack_" + document.location.hostname,
  UntrackText: text_content.UntrackText,
  TrackText: text_content.TrackText,
  TrackHint: text_content.TrackHint,

  init: function (containerID, useTagManager) {
    //cookie handling
    this.containerID = containerID;
    this.checkboxClass = "wk-checkbox";
    this.checkboxSelector = containerID + " ." + this.checkboxClass;

    jQuery(containerID).find(".form-table").append(`
		<tr>
			<th scope="row">${this.TrackText}</th>
			<td>
				<div id="wk-ga-opt-out">
					<input type="hidden" name="wk-ga-opt-out" value="0">
					<input class="${this.checkboxClass}" type="checkbox" name="wk-ga-opt-out">
					<span class="tooltip-text">${this.TrackHint}</span>
				</div>
				<style>
				#wk-ga-opt-out:hover .tooltip-text {
					display: inline-block;
				}

				#wk-ga-opt-out .tooltip-text {
					display: none;
				}
				</style>
			</td>
		</tr>
		`);

    this.renderCheckbox();

    jQuery(this.checkboxSelector).change(
      function () {
        this.handleClick();
      }.bind(this)
    );

    //analytics/tag manager switch
    this.onlyUseOne(jQuery(useTagManager).is(":checked"));

    jQuery(useTagManager).change(
      function () {
        this.onlyUseOne(jQuery(useTagManager).is(":checked"));
      }.bind(this)
    );
  },

  onlyUseOne: function (useIt) {
    switch (useIt) {
      case true: {
        jQuery(".use-google-tag-manager")
          .children("input")
          .prop("readonly", false);
        jQuery(".use-google-analytics")
          .children("input")
          .prop("readonly", true);
        break;
      }
      case false: {
        jQuery(".use-google-analytics")
          .children("input")
          .prop("readonly", false);
        jQuery(".use-google-tag-manager")
          .children("input")
          .prop("readonly", true);
        break;
      }
    }
  },

  renderCheckbox: function (containerID) {
    var checkboxValue = Cookies.get(this.CookieName) ? 1 : 0;
    console.log(checkboxValue);
    console.log(this.checkboxSelector);
    jQuery(this.checkboxSelector).prop("checked", checkboxValue);
  },

  handleClick: function () {
    console.log(this.CookieName);
    if (Cookies.get(this.CookieName)) {
      Cookies.remove(this.CookieName);
    } else {
      Cookies.set(this.CookieName, true, {
        expires: 365,
      });
    }
    this.renderCheckbox();
  },
};

jQuery(document).ready(function () {
  WKGA_AdminFunctions.init(
    "#wk-google-analytics-settings",
    "#use-google-tag-manager"
  );
});
