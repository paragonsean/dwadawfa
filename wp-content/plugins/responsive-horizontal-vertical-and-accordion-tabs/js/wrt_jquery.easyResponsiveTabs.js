(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals
        factory(jQuery);
    }
})(function ($) {
    // Easy Responsive Tabs Plugin
    // Author: Samson.Onna <Email : samson3d@gmail.com>
    $.fn.extend({
        easyResponsiveTabs: function (options) {
            //Set the default values, use comma to separate the settings, example:
            var defaults = {
                type: 'default', //default, vertical, accordion;
                width: 'auto',
                fit: true,
                closed: false,
                tabidentify: '',
                activetab_bg: 'white',
                inactive_bg: '#F5F5F5',
                active_border_color: '#c1c1c1',
                active_content_border_color: '#c1c1c1',
		history:false,
                activate: function () {
                }
            }
            //Variables
            var options = $.extend(defaults, options);
            var opt = options, jtype = opt.type, jfit = opt.fit, jwidth = opt.width, vtabs = 'vertical', accord = 'accordion';
            var hash = window.location.hash;
	    if(history==true){

	      var historyApi = !!(window.history && history.replaceState);

	    }
	    else{

		historyApi=false;
	    }

            //Events
            $(this).bind('tabactivate', function (e, currentTab) {
                if (typeof options.activate === 'function') {
                    options.activate.call(currentTab, e)
                }
            });

            //Main function
            this.each(function () {
                var $respTabs = $(this);
		if (jtype == vtabs) {

			var $respTabsList = $respTabs.find('ul.vresp-tabs-list.' + options.tabidentify);
		}
		else{
			var $respTabsList = $respTabs.find('ul.resp-tabs-list.' + options.tabidentify);
		}
                var respTabsId = $respTabs.attr('id');
		if (jtype == vtabs) {

			$respTabs.find('ul.vresp-tabs-list.' + options.tabidentify + ' li').addClass('vresp-tab-item').addClass(options.tabidentify);
		}
		else{

			$respTabs.find('ul.resp-tabs-list.' + options.tabidentify + ' li').addClass('resp-tab-item').addClass(options.tabidentify);
		}
                $respTabs.css({
                    'display': 'block',
                    'width': jwidth
                });

                if (options.type == 'vertical')
                    $respTabsList.css('margin-top', '3px');

		if (options.type == 'vertical'){


			$respTabs.find('.vresp-tabs-container.' + options.tabidentify).css('border-color', options.active_content_border_color);
			$respTabs.find('.vresp-tabs-container.' + options.tabidentify + ' > div').addClass('vresp-tab-content').addClass(options.tabidentify);
		}
		else{
			$respTabs.find('.resp-tabs-container.' + options.tabidentify).css('border-color', options.active_content_border_color);
			$respTabs.find('.resp-tabs-container.' + options.tabidentify + ' > div').addClass('resp-tab-content').addClass(options.tabidentify);
		}
                jtab_options();
                //Properties Function
                function jtab_options() {
                    if (jtype == vtabs) {
                        $respTabs.addClass('resp-vtabs').addClass(options.tabidentify);
                    }
                    if (jfit == true) {
                        $respTabs.css({ width: '100%', margin: '0px' });
                    }
                    if (jtype == accord) {
                        $respTabs.addClass('resp-easy-accordion').addClass(options.tabidentify);
                        $respTabs.find('.resp-tabs-list').css('display', 'none');
                    }
                }

                //Assigning the h2 markup to accordion title
                var $tabItemh2;
		if (options.type == 'vertical'){

			$respTabs.find('.vresp-tab-content.' + options.tabidentify).before("<h2heading class='resp-accordion " + options.tabidentify + "' role='tab'><span class='resp-arrow'></span></h2heading>");

			$respTabs.find('.vresp-tab-content.' + options.tabidentify).prev("h2heading").css({
			//'background-color': options.inactive_bg,
			'border-color': options.active_border_color
			});

		}
		else{

			$respTabs.find('.resp-tab-content.' + options.tabidentify).before("<h2heading class='resp-accordion " + options.tabidentify + "' role='tab'><span class='resp-arrow'></span></h2heading>");

			$respTabs.find('.resp-tab-content.' + options.tabidentify).prev("h2heading").css({
			//'background-color': options.inactive_bg,
			'border-color': options.active_border_color
			});
		}

                var itemCount = 0;
                $respTabs.find('.resp-accordion.'+options.tabidentify).each(function () {
                    $tabItemh2 = $(this);
		    if (options.type == 'vertical'){

		      var $tabItem = $respTabs.find('.vresp-tab-item.'+options.tabidentify+':eq(' + itemCount + ')');
		    }
		    else{
			var $tabItem = $respTabs.find('.resp-tab-item.'+options.tabidentify+':eq(' + itemCount + ')');
		    }
                    var $accItem = $respTabs.find('.resp-accordion.'+options.tabidentify+':eq(' + itemCount + ')');



		    if (typeof $($tabItem).attr('data-tabid') !== typeof undefined && $($tabItem).attr('data-tabid') !== false) {

			    $($accItem).attr('data-tabid',$($tabItem).attr('data-tabid'));
			    $($accItem).attr('data-isajaxloaded','0');
	            }
                    $accItem.append($tabItem.html());
                    $accItem.data($tabItem.data());
                    $tabItemh2.attr('aria-controls', options.tabidentify + '_tab_item-' + (itemCount));
                    itemCount++;
                });

                //Assigning the 'aria-controls' to Tab items
                var count = 0,
                $tabContent;
                $respTabs.find('li.'+options.tabidentify+"").each(function () {
                    $tabItem = $(this);
                    $tabItem.attr('aria-controls', options.tabidentify + '_tab_item-' + (count));
                    $tabItem.attr('role', 'tab');
                    $tabItem.css({

                    });

                    //Assigning the 'aria-labelledby' attr to tab-content
                    var tabcount = 0;
		    if (options.type == 'vertical'){
			$respTabs.find('.vresp-tab-content.' + options.tabidentify).each(function () {
				$tabContent = $(this);
				$tabContent.attr('aria-labelledby', options.tabidentify + '_tab_item-' + (tabcount)).css({
				'border-color': options.active_border_color
				});
				tabcount++;
			});
		    }
		    else{

			    $respTabs.find('.resp-tab-content.' + options.tabidentify).each(function () {
				$tabContent = $(this);
				$tabContent.attr('aria-labelledby', options.tabidentify + '_tab_item-' + (tabcount)).css({
				'border-color': options.active_border_color
				});
				tabcount++;
			});

		}
                    count++;
                });

                // Show correct content area
                var tabNum = 0;
                if (hash != '') {
                    var matches = hash.match(new RegExp(respTabsId + "([0-9]+)"));
                    if (matches !== null && matches.length === 2) {
                        tabNum = parseInt(matches[1], 10) - 1;
                        if (tabNum > count) {
                            tabNum = 0;
                        }
                    }
                }


                if (options.type == 'vertical'){

			 //Active correct tab
			$($respTabs.find('.vresp-tab-item.' + options.tabidentify)[tabNum]).addClass('vresp-tab-active').css({
			//'background-color': options.activetab_bg,
			'border-color': options.active_border_color
			});
		}
		else{

			 //Active correct tab
			$($respTabs.find('.resp-tab-item.' + options.tabidentify)[tabNum]).addClass('resp-tab-active').css({
			//'background-color': options.activetab_bg,
			'border-color': options.active_border_color
			});

		}


                //keep closed if option = 'closed' or option is 'accordion' and the element is in accordion mode
                if (options.closed !== true && !(options.closed === 'accordion' && !$respTabsList.is(':visible')) && !(options.closed === 'tabs' && $respTabsList.is(':visible'))) {


		    if (options.type == 'vertical'){

			     $($respTabs.find('.resp-accordion.' + options.tabidentify)[tabNum]).addClass('vresp-tab-active').css({
					//'background-color': options.activetab_bg + ' !important',
					'border-color': options.active_border_color
					//'background': 'none'
				});

			     $($respTabs.find('.vresp-tab-content.' + options.tabidentify)[tabNum]).addClass('vresp-tab-content-active').addClass(options.tabidentify).attr('style', 'display:block');
		    }
		    else{

			 $($respTabs.find('.resp-accordion.' + options.tabidentify)[tabNum]).addClass('resp-tab-active').css({
				//'background-color': options.activetab_bg + ' !important',
				'border-color': options.active_border_color
				//'background': 'none'
			});
                         $($respTabs.find('.resp-tab-content.' + options.tabidentify)[tabNum]).addClass('resp-tab-content-active').addClass(options.tabidentify).attr('style', 'display:block');
		    }
                }
                //assign proper classes for when tabs mode is activated before making a selection in accordion mode
                else {
                    // $($respTabs.find('.resp-tab-content.' + options.tabidentify)[tabNum]).addClass('resp-accordion-closed'); //removed resp-tab-content-active
                }

                //Tab Click action function
                $respTabs.find("."+options.tabidentify+"[role=tab]").each(function () {

                    var $currentTab = $(this);
                    $currentTab.click(function () {

                        var $currentTab = $(this);
                        var $tabAria = $currentTab.attr('aria-controls');

			if (options.type == 'vertical'){
				if ($currentTab.hasClass('resp-accordion') && $currentTab.hasClass('vresp-tab-active')) {
				$respTabs.find('.vresp-tab-content-active.' + options.tabidentify).slideUp('', function () {
					$(this).addClass('resp-accordion-closed');
				});
				$currentTab.removeClass('vresp-tab-active').css({
					//'background-color': options.inactive_bg,
					'border-color': 'none'
				});
				return false;
				}
			}
			else{

				if ($currentTab.hasClass('resp-accordion') && $currentTab.hasClass('resp-tab-active')) {
				$respTabs.find('.resp-tab-content-active.' + options.tabidentify).slideUp('', function () {
					$(this).addClass('resp-accordion-closed');
				});
				$currentTab.removeClass('resp-tab-active').css({
					//'background-color': options.inactive_bg,
					'border-color': 'none'
				});
				return false;
				}

			}

                        if (!$currentTab.hasClass('resp-tab-active') && !$currentTab.hasClass('vresp-tab-active') && $currentTab.hasClass('resp-accordion')) {


			    if (options.type == 'vertical'){

				     $respTabs.find('.vresp-tab-active.' + options.tabidentify).removeClass('vresp-tab-active').css({
					//'background-color': options.inactive_bg,
					'border-color': 'none'
				   });

				    $respTabs.find('.vresp-tab-content-active.' + options.tabidentify).slideUp().removeClass('vresp-tab-content-active resp-accordion-closed');

				    $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('vresp-tab-active').css({
					//'background-color': options.activetab_bg,
					'border-color': options.active_border_color
				});

			     }
			    else{

				   $respTabs.find('.resp-tab-active.' + options.tabidentify).removeClass('resp-tab-active').css({
					//'background-color': options.inactive_bg,
					'border-color': 'none'
			         	});
                                    $respTabs.find('.resp-tab-content-active.' + options.tabidentify).slideUp().removeClass('resp-tab-content-active resp-accordion-closed');

				    $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('resp-tab-active').css({
						//'background-color': options.activetab_bg,
						'border-color': options.active_border_color
					});

			    }


			    if (options.type == 'vertical'){

				$respTabs.find('.vresp-tab-content[aria-labelledby = ' + $tabAria + '].' + options.tabidentify).slideDown().addClass('vresp-tab-content-active');
			    }
			    else{
				    $respTabs.find('.resp-tab-content[aria-labelledby = ' + $tabAria + '].' + options.tabidentify).slideDown().addClass('resp-tab-content-active');

				}

                        } else {


			    if (options.type == 'vertical'){

				     //console.log('here');
					$respTabs.find('.vresp-tab-active.' + options.tabidentify).removeClass('vresp-tab-active').css({
						//'background-color': options.inactive_bg,
						'border-color': 'none'
					});

				      $respTabs.find('.vresp-tab-content-active.' + options.tabidentify).removeAttr('style').removeClass('vresp-tab-content-active').removeClass('resp-accordion-closed');
			    }
			    else{

				     //console.log('here');
					$respTabs.find('.resp-tab-active.' + options.tabidentify).removeClass('resp-tab-active').css({
						//'background-color': options.inactive_bg,
						'border-color': 'none'
					});

					$respTabs.find('.resp-tab-content-active.' + options.tabidentify).removeAttr('style').removeClass('resp-tab-content-active').removeClass('resp-accordion-closed');

			    }



			    if (options.type == 'vertical'){

				      $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('vresp-tab-active').css({
						//'background-color': options.activetab_bg,
						'border-color': options.active_border_color
					});

				    $respTabs.find('.vresp-tab-content[aria-labelledby = ' + $tabAria + '].' + options.tabidentify).addClass('vresp-tab-content-active').attr('style', 'display:block');
			    }
			    else{

				     $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('resp-tab-active').css({
						//'background-color': options.activetab_bg,
						'border-color': options.active_border_color
					});
                                   $respTabs.find('.resp-tab-content[aria-labelledby = ' + $tabAria + '].' + options.tabidentify).addClass('resp-tab-content-active').attr('style', 'display:block');
			    }
                        }
                        //Trigger tab activation event
                        $currentTab.trigger('tabactivate', $currentTab);

                        //Update Browser History
                        if (historyApi) {
                            var currentHash = window.location.hash;
			    var tabAriaParts = $tabAria.split('tab_item-');
                            // var newHash = respTabsId + (parseInt($tabAria.substring(9), 10) + 1).toString();
                            var newHash = respTabsId + (parseInt(tabAriaParts[1], 10) + 1).toString();

                            if (currentHash != "") {
			        var re = new RegExp(respTabsId + "[0-9]+");
                                if (currentHash.match(re) != null) {
                                    newHash = currentHash.replace(re, newHash);
                                }
                                else {
                                    newHash = currentHash + "|" + newHash;
                                }
                            }
                            else {
                                newHash = '#' + newHash;
                            }

                            history.replaceState(null, null, newHash);
                        }
                    });

                });

                //Window resize function
                $(window).resize(function () {
                    $respTabs.find('.resp-accordion-closed').removeAttr('style');
                });
            });
        }
    });
});
