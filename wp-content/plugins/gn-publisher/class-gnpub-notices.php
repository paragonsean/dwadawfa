<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GNPUB_Notices {

	protected $notices;

	public function __construct() {
		$this->notices = array();
	}

	public function add_notice( $notice, $status = 'success' ) {
		$valid_statuses = array( 'success', 'warning', 'error' );

		if ( ! in_array( $status, $valid_statuses ) ) {
			return false;
		}

		$this->notices[] = array( $status, $notice );

		return true;
	}

	public function get_notices( $status = null ) {
		usort( $this->notices, function( $notice_a, $notice_b ) {
			return strcmp( $notice_a[0], $notice_b[0] );
		} );

		if ( ! $status ) {
			return $this->notices;
		}

		return array_filter( $this->notices, function( $notice ) use ( $status ) {
			return $status === $notice[0];
		} );
	}

	public function display_notices() {
		$notices = $this->get_notices();
		if(!empty($notices)){
		foreach ( $notices as $notice ){ 
			if(isset($notice[0]) && isset($notice[1])){?>
			<div class="notice notice-<?php echo esc_attr($notice[0]); ?>">
				<p><?php echo esc_html($notice[1]); ?></p>
			</div>
		<?php }
		   }
		}
	}

}