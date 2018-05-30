/*
 * Google Analytics by WebKinder
 * Admin JS Functions
 */

 var WKGA_AdminFunctions = {
 	CookieName: 'wp_wk_ga_untrack_' + document.location.hostname,
 	UntrackText: text_content.UntrackText,
 	TrackText: text_content.TrackText,

 	init: function( containerID, useTagManager ) {

    //cookie handling
 		this.containerID = containerID;
    this.checkboxClass = 'wk-checkbox';
 		this.checkboxSelector = containerID + " ." + this.checkboxClass;
 		jQuery( containerID ).html('<input type="checkbox" class="'+this.checkboxClass+'" id="wk-ga-opt-out" /><label for="wk-ga-opt-out">'+this.TrackText+' </label>');

 		this.renderCheckbox();

 		jQuery( this.checkboxSelector ).change( function() {
 			this.handleClick();
 		}.bind(this) );

    //analytics/tag manager switch
    this.onlyUseOne( jQuery( useTagManager ).is(":checked") );

    jQuery( useTagManager ).change( function() {
      this.onlyUseOne( jQuery( useTagManager ).is(":checked") );
    }.bind(this));

 	},

  onlyUseOne: function( useIt ) {
    switch( useIt ) {
      case true: {
        jQuery('.use-google-tag-manager').children('input').prop('readonly', false);
        jQuery('.use-google-analytics').children('input').prop('readonly', true);
        break;
      }
      case false: {
        jQuery('.use-google-analytics').children('input').prop('readonly', false);
        jQuery('.use-google-tag-manager').children('input').prop('readonly', true);
        break;
      }
    }
  },

 	renderCheckbox: function( containerID ) {
 		var checkboxValue	= Cookies.get( this.CookieName ) ? 1 : 0;
 		jQuery( this.checkboxSelector ).prop('checked', checkboxValue );
	},

 	handleClick: function() {
 		if( Cookies.get( this.CookieName ) ) {
 			Cookies.remove( this.CookieName );
 		} else {
 			Cookies.set( this.CookieName , true, { expires: 365 } );
 		}
 		this.renderCheckbox();
 	}

 }

 jQuery(document).ready(function(){

 	WKGA_AdminFunctions.init( '#track-device', '#use-google-tag-manager' );

 });
