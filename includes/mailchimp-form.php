<?php
/*
 * Google Analytics by WebKinder
 * Mailchimp form for settings page
 */
?>
<!-- Begin MailChimp Signup Form -->
<div id="mc_embed_signup">
    <form action="//webkinder.us12.list-manage.com/subscribe/post?u=979fe90d29c9ca9e25d5acc4b&amp;id=dfae840228"
        method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank"
        novalidate>
        <div id="mc_embed_signup_scroll">
            <h2><?php _e("Stay informed about any changes to this plugin", 'wk-google-analytics'); ?></h2>
            <div class="mc-field-group">
                <label for="mce-EMAIL"><?php _e("Email address", 'wk-google-analytics'); ?><span
                        class="asterisk">*</span></label>
                <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
            </div>
            <div class="mc-field-group">
                <label for="mce-FNAME"><?php _e("First name", 'wk-google-analytics'); ?><span
                        class="asterisk">*</span></label>
                <input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
            </div>
            <div class="mc-field-group">
                <label for="mce-LNAME"><?php _e("Last name", 'wk-google-analytics'); ?><span
                        class="asterisk">*</span></label>
                <input type="text" value="" name="LNAME" class="required" id="mce-LNAME">
            </div>
            <div class="mc-field-group input-group">
                <strong><?php _e("Permission", 'wk-google-analytics'); ?></strong>
                <input type="checkbox" value="1" name="group[16549][1]" id="mce-group[16549]-16549-0"><label
                    for="mce-group[16549]-16549-0"><?php _e("I agree that my personal data will be stored and used to send plugin updates to my email address.", 'wk-google-analytics'); ?></label>
                </ul>
                <div id="mce-responses" class="clear">
                    <div class="response" id="mce-error-response" style="display:none"></div>
                    <div class="response" id="mce-success-response" style="display:none"></div>
                </div>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;" aria-hidden="true">
                    <input type="text" name="b_979fe90d29c9ca9e25d5acc4b_dfae840228" tabindex="-1" value="">
                </div>
                <div class="clear">
                    <input type="submit" value="<?php _e("Subscribe", 'wk-google-analytics'); ?>" name="subscribe"
                        id="mc-embedded-subscribe" class="button button-primary">
                </div>
            </div>
    </form>
</div>
<!--End mc_embed_signup-->