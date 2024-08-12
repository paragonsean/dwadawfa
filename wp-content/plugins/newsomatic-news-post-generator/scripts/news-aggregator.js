"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'newsomatic-news-post-generator/newsomatic-aggregator', {
    title: 'Newsomatic News Aggregator',
    icon: 'testimonial',
    category: 'embed',
    attributes: {
        max_news_number : {
            default: 9,
            type:   'string',
        },
        layout : {
            default: 'ticker',
            type:   'string',
        },
        grid_columns : {
            default: '',
            type:   '3',
        },
        title_max_length : {
            default: '6',
            type:   'string',
        },
        desciption_max_length : {
            default: '18',
            type:   'string',
        },
        display_news_source : {
            default: 'false',
            type:   'string',
        },
        display_date : {
            default: 'false',
            type:   'string',
        },
        enable_rtl : {
            default: 'false',
            type:   'string',
        },
        enable_font_awesome : {
            default: 'false',
            type:   'string',
        },
        show_description : {
            default: 'true',
            type:   'string',
        },
        show_source_name : {
            default: 'false',
            type:   'string',
        },
        country : {
            default: '',
            type:   'string',
        },
        language : {
            default: '',
            type:   'string',
        },
        sources : {
            default: 'CNET',
            type:   'string',
        },
        query_string : {
            default: '',
            type:   'string',
        },
        query_string_title : {
            default: '',
            type:   'string',
        },
        sort_results : {
            default: '',
            type:   'string',
        },
        only_domains : {
            default: '',
            type:   'string',
        },
        remove_domains : {
            default: '',
            type:   'string',
        },
        from_date : {
            default: '',
            type:   'string',
        },
        to_date : {
            default: '',
            type:   'string',
        },
        ticker_type : {
            default: 'marquee',
            type:   'string',
        },
        ticker_text_color : {
            default: 'red',
            type:   'string',
        },
        ticker_label_color : {
            default: 'white',
            type:   'string',
        },
        ticker_color : {
            default: 'red',
            type:   'string',
        },
        caching_time : {
            default: 360,
            type:   'string',
        }
    },
    keywords: ['list', 'posts', 'newsomatic'],
    edit: (function( props ) {
		var max_news_number = props.attributes.max_news_number;
        var layout = props.attributes.layout;
        var grid_columns = props.attributes.grid_columns;
        var title_max_length = props.attributes.title_max_length;
        var desciption_max_length = props.attributes.desciption_max_length;
        var display_news_source = props.attributes.display_news_source;
        var display_date = props.attributes.display_date;
        var enable_rtl = props.attributes.enable_rtl;
        var enable_font_awesome = props.attributes.enable_font_awesome;
        var show_description = props.attributes.show_description;
        var show_source_name = props.attributes.show_source_name;
        var country = props.attributes.country;
        var language = props.attributes.language;
        var sources = props.attributes.sources;
        var query_string = props.attributes.query_string;
        var query_string_title = props.attributes.query_string_title;
        var sort_results = props.attributes.sort_results;
        var only_domains = props.attributes.only_domains;
        var remove_domains = props.attributes.remove_domains;
        var from_date = props.attributes.from_date;
        var to_date = props.attributes.to_date;
        var ticker_type = props.attributes.ticker_type;
        var ticker_text_color = props.attributes.ticker_text_color;
        var ticker_label_color = props.attributes.ticker_label_color;
        var ticker_color = props.attributes.ticker_color;
        var caching_time = props.attributes.caching_time;
		function updateMessage( event ) {
            props.setAttributes( { max_news_number: event.target.value} );
		}
        function updateMessage2( event ) {
            props.setAttributes( { layout: event.target.value} );
		}
        function updateMessage3( event ) {
            props.setAttributes( { grid_columns: event.target.value} );
		}
        function updateMessage4( event ) {
            props.setAttributes( { title_max_length: event.target.value} );
		}
        function updateMessage5( event ) {
            props.setAttributes( { desciption_max_length: event.target.value} );
		}
        function updateMessage6( event ) {
            props.setAttributes( { display_news_source: event.target.value} );
		}
        function updateMessage7( event ) {
            props.setAttributes( { display_date: event.target.value} );
		}
        function updateMessage8( event ) {
            props.setAttributes( { enable_rtl: event.target.value} );
		}
        function updateMessage9( event ) {
            props.setAttributes( { enable_font_awesome: event.target.value} );
		}
        function updateMessage10( event ) {
            props.setAttributes( { show_description: event.target.value} );
		}
        function updateMessage11( event ) {
            props.setAttributes( { show_source_name: event.target.value} );
		}
        function updateMessage12( event ) {
            props.setAttributes( { country: event.target.value} );
		}
        function updateMessage13( event ) {
            props.setAttributes( { language: event.target.value} );
		}
        function updateMessage14( event ) {
            props.setAttributes( { sources: event.target.value} );
		}
        function updateMessage15( event ) {
            props.setAttributes( { query_string: event.target.value} );
		}
        function updateMessage16( event ) {
            props.setAttributes( { query_string_title: event.target.value} );
		}
        function updateMessage17( event ) {
            props.setAttributes( { sort_results: event.target.value} );
		}
        function updateMessage18( event ) {
            props.setAttributes( { only_domains: event.target.value} );
		}
        function updateMessage19( event ) {
            props.setAttributes( { remove_domains: event.target.value} );
		}
        function updateMessage20( event ) {
            props.setAttributes( { from_date: event.target.value} );
		}
        function updateMessage21( event ) {
            props.setAttributes( { to_date: event.target.value} );
		}
        function updateMessage22( event ) {
            props.setAttributes( { ticker_type: event.target.value} );
		}
        function updateMessage23( event ) {
            props.setAttributes( { ticker_text_color: event.target.value} );
		}
        function updateMessage24( event ) {
            props.setAttributes( { ticker_label_color: event.target.value} );
		}
        function updateMessage25( event ) {
            props.setAttributes( { ticker_color: event.target.value} );
		}
        function updateMessage26( event ) {
            props.setAttributes( { caching_time: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'Newsomatic News Aggregator ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to aggregate news from different sources supported by NewsomaticAPI.'
                    )
                )
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Max Number Of News Items To List: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the maximum number of news items to list.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:1,placeholder:'Max item count', value: max_news_number, onChange: updateMessage, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Layout: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the results layout.'
                )
            ),
            gcel(
				'select',
				{ value: layout, onChange: updateMessage2, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'ticker'},
                    'Ticker'
                ), 
                gcel(
                    'option',
                    { value: 'grid'},
                    'Grid'
                ), 
                gcel(
                    'option',
                    { value: 'list'},
                    'List'
                ), 
                gcel(
                    'option',
                    { value: 'plain'},
                    'Plain'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Number of Grid Columns: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the number of grid columns.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:1,placeholder:'Grid column count', value: grid_columns, onChange: updateMessage3, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Title Max Word Count: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the maximum word count for titles.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:1,placeholder:'Title max word count', value: title_max_length, onChange: updateMessage4, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Description Max Word Count: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the maximum word count for description.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:1,placeholder:'Description max word count', value: desciption_max_length, onChange: updateMessage5, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Display News Source Name: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the if you wish to display the news source name.'
                )
            ),
            gcel(
				'select',
				{ value: display_news_source, onChange: updateMessage6, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'true'},
                    'Yes'
                ), 
                gcel(
                    'option',
                    { value: 'false'},
                    'No'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Display Date: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the if you wish to display the news date.'
                )
            ),
            gcel(
				'select',
				{ value: display_date, onChange: updateMessage7, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'true'},
                    'Yes'
                ), 
                gcel(
                    'option',
                    { value: 'false'},
                    'No'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Enable RTL: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the if you wish to enable RTL styling.'
                )
            ),
            gcel(
				'select',
				{ value: enable_rtl, onChange: updateMessage8, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'true'},
                    'Yes'
                ), 
                gcel(
                    'option',
                    { value: 'false'},
                    'No'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Enable Font Awesome: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the if you wish to enable font awesome icons.'
                )
            ),
            gcel(
				'select',
				{ value: enable_font_awesome, onChange: updateMessage9, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'true'},
                    'Yes'
                ), 
                gcel(
                    'option',
                    { value: 'false'},
                    'No'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show News Description: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the if you wish to show news description.'
                )
            ),
            gcel(
				'select',
				{ value: show_description, onChange: updateMessage10, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'true'},
                    'Yes'
                ), 
                gcel(
                    'option',
                    { value: 'false'},
                    'No'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show Source Name: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the if you wish to show source name of the news.'
                )
            ),
            gcel(
				'select',
				{ value: show_source_name, onChange: updateMessage11, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'true'},
                    'Yes'
                ), 
                gcel(
                    'option',
                    { value: 'false'},
                    'No'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Filter Country: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the country to filter posts for.'
                )
            ),
            gcel(
				'select',
				{ value: country, onChange: updateMessage12, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'all'},
                    'All'
                ), 
                gcel(
                    'option',
                    { value: 'ar'},
                    'Argentina'
                ), 
                gcel(
                    'option',
                    { value: 'au'},
                    'Australia'
                ), 
                gcel(
                    'option',
                    { value: 'br'},
                    'Brasil'
                ), 
                gcel(
                    'option',
                    { value: 'ca'},
                    'Canada'
                ), 
                gcel(
                    'option',
                    { value: 'cn'},
                    'China'
                ), 
                gcel(
                    'option',
                    { value: 'cz'},
                    'Czech Republic'
                ), 
                gcel(
                    'option',
                    { value: 'de'},
                    'Germany'
                ), 
                gcel(
                    'option',
                    { value: 'es'},
                    'Spain'
                ), 
                gcel(
                    'option',
                    { value: 'fr'},
                    'France'
                ), 
                gcel(
                    'option',
                    { value: 'gb'},
                    'Great Britain'
                ), 
                gcel(
                    'option',
                    { value: 'ie'},
                    'Republic of Ireland'
                ), 
                gcel(
                    'option',
                    { value: 'in'},
                    'India'
                ), 
                gcel(
                    'option',
                    { value: 'it'},
                    'Italy'
                ), 
                gcel(
                    'option',
                    { value: 'nl'},
                    'Netherlands'
                ), 
                gcel(
                    'option',
                    { value: 'no'},
                    'Norway'
                ), 
                gcel(
                    'option',
                    { value: 'pk'},
                    'Pakistan'
                ), 
                gcel(
                    'option',
                    { value: 'ru'},
                    'Russia'
                ), 
                gcel(
                    'option',
                    { value: 'sa'},
                    'Saudi Arabia'
                ), 
                gcel(
                    'option',
                    { value: 'se'},
                    'Sweden'
                ), 
                gcel(
                    'option',
                    { value: 'us'},
                    'United States'
                ), 
                gcel(
                    'option',
                    { value: 'za'},
                    'South Africa'
                ), 
                gcel(
                    'option',
                    { value: 'ae'},
                    'United Arab Emirates'
                ), 
                gcel(
                    'option',
                    { value: 'at'},
                    'Austria'
                ), 
                gcel(
                    'option',
                    { value: 'be'},
                    'Belgium'
                ), 
                gcel(
                    'option',
                    { value: 'bg'},
                    'Bulgaria'
                ), 
                gcel(
                    'option',
                    { value: 'ch'},
                    'Switzerland'
                ), 
                gcel(
                    'option',
                    { value: 'co'},
                    'Colombia'
                ), 
                gcel(
                    'option',
                    { value: 'cu'},
                    'Cuba'
                ), 
                gcel(
                    'option',
                    { value: 'eg'},
                    'Egypt'
                ), 
                gcel(
                    'option',
                    { value: 'gh'},
                    'Ghana'
                ), 
                gcel(
                    'option',
                    { value: 'gr'},
                    'Greece'
                ), 
                gcel(
                    'option',
                    { value: 'hk'},
                    'Hong Kong'
                ), 
                gcel(
                    'option',
                    { value: 'hu'},
                    'Hungary'
                ), 
                gcel(
                    'option',
                    { value: 'id'},
                    'Indonesia'
                ), 
                gcel(
                    'option',
                    { value: 'is'},
                    'Israel'
                ), 
                gcel(
                    'option',
                    { value: 'jp'},
                    'Japan'
                ), 
                gcel(
                    'option',
                    { value: 'kr'},
                    'South Korea'
                ), 
                gcel(
                    'option',
                    { value: 'lt'},
                    'Lithuania'
                ), 
                gcel(
                    'option',
                    { value: 'lv'},
                    'Latvia'
                ), 
                gcel(
                    'option',
                    { value: 'ma'},
                    'Morocco'
                ), 
                gcel(
                    'option',
                    { value: 'mx'},
                    'Mexico'
                ), 
                gcel(
                    'option',
                    { value: 'my'},
                    'Malaysia'
                ), 
                gcel(
                    'option',
                    { value: 'ng'},
                    'Nigeria'
                ), 
                gcel(
                    'option',
                    { value: 'nz'},
                    'New Zealand'
                ), 
                gcel(
                    'option',
                    { value: 'pe'},
                    'Peru'
                ), 
                gcel(
                    'option',
                    { value: 'ph'},
                    'Philippines'
                ), 
                gcel(
                    'option',
                    { value: 'pl'},
                    'Poland'
                ), 
                gcel(
                    'option',
                    { value: 'pt'},
                    'Portugal'
                ), 
                gcel(
                    'option',
                    { value: 'ro'},
                    'Romania'
                ), 
                gcel(
                    'option',
                    { value: 'rs'},
                    'Serbia'
                ), 
                gcel(
                    'option',
                    { value: 'sg'},
                    'Singapore'
                ), 
                gcel(
                    'option',
                    { value: 'si'},
                    'Slovenia'
                ), 
                gcel(
                    'option',
                    { value: 'sk'},
                    'Slovakia'
                ), 
                gcel(
                    'option',
                    { value: 'th'},
                    'Thailand'
                ), 
                gcel(
                    'option',
                    { value: 'tr'},
                    'Turkey'
                ), 
                gcel(
                    'option',
                    { value: 'tt'},
                    'Trinidad and Tobago'
                ), 
                gcel(
                    'option',
                    { value: 'tw'},
                    'Taiwan'
                ), 
                gcel(
                    'option',
                    { value: 'ua'},
                    'Ukraine'
                ), 
                gcel(
                    'option',
                    { value: 've'},
                    'Venezuela'
                ), 
                gcel(
                    'option',
                    { value: 'vn'},
                    'Vietnam'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Filter Language: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the language to filter posts for.'
                )
            ),
            gcel(
				'select',
				{ value: language, onChange: updateMessage13, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'all'},
                    'All'
                ), 
                gcel(
                    'option',
                    { value: 'en'},
                    'English'
                ), 
                gcel(
                    'option',
                    { value: 'cz'},
                    'Czech'
                ), 
                gcel(
                    'option',
                    { value: 'ar'},
                    'Arabic'
                ), 
                gcel(
                    'option',
                    { value: 'bg'},
                    'Bulgarian'
                ), 
                gcel(
                    'option',
                    { value: 'zh'},
                    'Chinese'
                ), 
                gcel(
                    'option',
                    { value: 'de'},
                    'German'
                ), 
                gcel(
                    'option',
                    { value: 'es'},
                    'Spanish'
                ), 
                gcel(
                    'option',
                    { value: 'fr'},
                    'French'
                ), 
                gcel(
                    'option',
                    { value: 'gr'},
                    'Greek'
                ), 
                gcel(
                    'option',
                    { value: 'he'},
                    'Hebrew'
                ), 
                gcel(
                    'option',
                    { value: 'hu'},
                    'Hungarian'
                ), 
                gcel(
                    'option',
                    { value: 'hd'},
                    'Hindi'
                ), 
                gcel(
                    'option',
                    { value: 'id'},
                    'Indonesian'
                ), 
                gcel(
                    'option',
                    { value: 'kr'},
                    'Korean'
                ), 
                gcel(
                    'option',
                    { value: 'it'},
                    'Italian'
                ), 
                gcel(
                    'option',
                    { value: 'lv'},
                    'Latvian'
                ), 
                gcel(
                    'option',
                    { value: 'lt'},
                    'Lithuanian'
                ), 
                gcel(
                    'option',
                    { value: 'pl'},
                    'Polish'
                ), 
                gcel(
                    'option',
                    { value: 'ro'},
                    'Romanian'
                ), 
                gcel(
                    'option',
                    { value: 'cr'},
                    'Croatian'
                ), 
                gcel(
                    'option',
                    { value: 'rs'},
                    'Bosnian'
                ), 
                gcel(
                    'option',
                    { value: 'sx'},
                    'Serbian'
                ), 
                gcel(
                    'option',
                    { value: 'si'},
                    'Slovenian'
                ), 
                gcel(
                    'option',
                    { value: 'sk'},
                    'Slovak'
                ), 
                gcel(
                    'option',
                    { value: 'nl'},
                    'Dutch'
                ), 
                gcel(
                    'option',
                    { value: 'no'},
                    'Norwegian'
                ), 
                gcel(
                    'option',
                    { value: 'pt'},
                    'Portuguese'
                ), 
                gcel(
                    'option',
                    { value: 'ru'},
                    'Russian'
                ), 
                gcel(
                    'option',
                    { value: 'se'},
                    'Swedish'
                ), 
                gcel(
                    'option',
                    { value: 'ud'},
                    'Urdu'
                ), 
                gcel(
                    'option',
                    { value: 'vn'},
                    'Vietnamese'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'News Source: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the post source to use.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'News source', value: sources, onChange: updateMessage14, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Query String: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the query string to search.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Query String', value: query_string, onChange: updateMessage15, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Title Query String: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the title query string to search.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Title Query String', value: query_string_title, onChange: updateMessage16, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Sort Results By: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select how to sort results.'
                )
            ),
            gcel(
				'select',
				{ value: sort_results, onChange: updateMessage17, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'publishedAt'},
                    'Latest'
                ), 
                gcel(
                    'option',
                    { value: 'popularity'},
                    'Popularity'
                ), 
                gcel(
                    'option',
                    { value: 'relevancy'},
                    'Relevancy'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Only Domains: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Filter results only for these domains.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Only These Domains', value: only_domains, onChange: updateMessage18, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Remove Domains: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Remove these domains from results.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Remove These Domains', value: remove_domains, onChange: updateMessage19, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'From Date: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Filter results from this date.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'From Date', value: from_date, onChange: updateMessage20, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'To Date: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Filter results to this date.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'To Date', value: to_date, onChange: updateMessage21, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Ticker Type: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the ticker type to use (applicable only for the ticker layout).'
                )
            ),
            gcel(
				'select',
				{ value: ticker_type, onChange: updateMessage22, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'marquee'},
                    'marquee'
                ), 
                gcel(
                    'option',
                    { value: 'horizontal'},
                    'horizontal'
                ), 
                gcel(
                    'option',
                    { value: 'typewriter'},
                    'typewriter'
                ), 
                gcel(
                    'option',
                    { value: 'vertical'},
                    'vertical'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Ticker Text Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the ticker text color.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Ticker Text Color', value: ticker_text_color, onChange: updateMessage23, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Ticker Label Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the ticker label color.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Ticker Text Color', value: ticker_label_color, onChange: updateMessage24, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Ticker Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the ticker color.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Ticker Color', value: ticker_color, onChange: updateMessage25, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Caching Time (Minutes): '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the caching time (in minutes).'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:1,placeholder:'Caching Time', value: caching_time, onChange: updateMessage26, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );