    "use strict";
    jQuery( document ).ready(function() {
		var container = jQuery('.newsomatic-five-star-wp-rate-action');
		if (container.length) {
			container.find('a').on('click', function() {
				container.remove();
				jQuery.post(
					ajaxurl,
					{
						action: 'newsomatic-five-star-wp-rate'
					},
					function(result) {}
				);
			});
		}
	});