<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: General Settings
*/
trait Wtn_General_Settings
{
    protected $fields, $settings, $options;
    
    protected function wtn_set_general_settings( $post ) {

        $this->fields   = $this->wtn_general_option_fileds();

        $this->options  = $this->wtn_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wtn_settings', $this->options, $post );

        return update_option( 'wtn_settings', $this->settings );

    }

    protected function wtn_get_general_settings() {

        $this->fields   = $this->wtn_general_option_fileds();
		$this->settings = get_option('wtn_settings');
        
        return $this->wtn_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wtn_general_option_fileds() {

        return [
            [
                'name'      => 'wtn_select_source',
                'type'      => 'string',
                'default'   => 'cnn',
            ],
            [
                'name'      => 'wtn_news_number',
                'type'      => 'number',
                'default'   => 10,
            ],
            [
                'name'      => 'wtn_layout',
                'type'      => 'string',
                'default'   => 'grid',
            ],
            [
                'name'      => 'wtn_grid_columns',
                'type'      => 'number',
                'default'   => 3,
            ],
            [
                'name'      => 'wtn_title_length',
                'type'      => 'number',
                'default'   => 4,
            ],
            [
                'name'      => 'wtn_desc_length',
                'type'      => 'number',
                'default'   => 18,
            ],
            [
                'name'      => 'wtn_display_news_source',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wtn_display_date',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wtn_enable_rtl',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wtn_ticker_type',
                'type'      => 'string',
                'default'   => 'marquee',
            ],
        ];
    }
}