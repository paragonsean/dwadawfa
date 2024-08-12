var strict;

jQuery(document).ready(function ($) {
    /**
     * DEACTIVATION FEEDBACK FORM
     */
    // show overlay when clicked on "deactivate"
    gnpub_deactivate_link = $('.wp-admin.plugins-php tr[data-slug="gn-publisher"] .row-actions .deactivate a');
    gnpub_deactivate_link_url = gnpub_deactivate_link.attr('href');

    gnpub_deactivate_link.click(function (e) {
        e.preventDefault();
        
        // only show feedback form once per 30 days
        var c_value = gnpub_admin_get_cookie("gnpub_hide_deactivate_feedback");

        if (c_value === undefined) {
            $('#gnpub-feedback-overlay').show();
        } else {
            // click on the link
            window.location.href = gnpub_deactivate_link_url;
        }
    });
    // show text fields
    $('#gnpub-feedback-content input[type="radio"]').click(function () {
        // show text field if there is one
        var input_value = $(this).attr("value");
        var target_box = $("." + input_value);
        $(".mb-box").not(target_box).hide();
        $(target_box).show();
    });
    // send form or close it
    $('#gnpub-feedback-content .button').click(function (e) {
        e.preventDefault();
        // set cookie for 30 days
        var exdate = new Date();
        exdate.setSeconds(exdate.getSeconds() + 2592000);
        document.cookie = "gnpub_hide_deactivate_feedback=1; expires=" + exdate.toUTCString() + "; path=/";

        $('#gnpub-feedback-overlay').hide();
        if ('gnpub-feedback-submit' === this.id) {
            // Send form data
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    action: 'gnpub_send_feedback',
                    data: $('#gnpub-feedback-content form').serialize(),
                    gn_security_nonce:gn_pub_script_vars.nonce
                },
                complete: function (MLHttpRequest, textStatus, errorThrown) {
                    // deactivate the plugin and close the popup
                    $('#gnpub-feedback-overlay').remove();
                    window.location.href = gnpub_deactivate_link_url;

                }
            });
        } else {
            $('#gnpub-feedback-overlay').remove();
            window.location.href = gnpub_deactivate_link_url;
        }
    });
    // close form without doing anything
    $('.gnpub-feedback-not-deactivate').click(function (e) {
        $('#gnpub-feedback-overlay').hide();
    });
    
    function gnpub_admin_get_cookie (name) {
	var i, x, y, gnpub_cookies = document.cookie.split( ";" );
	for (i = 0; i < gnpub_cookies.length; i++)
	{
		x = gnpub_cookies[i].substr( 0, gnpub_cookies[i].indexOf( "=" ) );
		y = gnpub_cookies[i].substr( gnpub_cookies[i].indexOf( "=" ) + 1 );
		x = x.replace( /^\s+|\s+$/g, "" );
		if (x === name)
		{
			return unescape( y );
		}
	}
}

}); // document ready