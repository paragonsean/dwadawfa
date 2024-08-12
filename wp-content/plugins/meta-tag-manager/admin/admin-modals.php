<?php
namespace Meta_Tag_Manager;

// admin modal notices
class Admin_Modals {
	
	public static $output_js = false;
	
	public static function init() {
		add_filter('admin_enqueue_scripts', array( static::class, 'admin_enqueue_scripts' ), 100);
		add_filter('wp_ajax_mtm-admin-popup-modal', array( static::class, 'ajax' ));
		add_filter('mtm_admin_notice_review-nudge_message', array( static::class, 'review_notice' ));
		if( time() < 1711962000 ) {
			add_filter( 'mtm_admin_notice_promo-popup_message', array( static::class, 'promo_notice' ) );
		}
		add_filter( 'mtm_admin_notice_expired-reminder_message', array( static::class, 'expired_reminder_notice' ) );
		add_filter( 'mtm_admin_notice_expiry-reminder_message', array( static::class, 'expiry_reminder_notice' ) );
	}
	
	public static function admin_enqueue_scripts(){
		if( !current_user_can('update_plugins') ) return;
		// show modal
		$data = is_multisite() ? get_site_option('mtm_admin_notices') : get_option('mtm_admin_notices');
		
		
		if( !empty($data['admin-modals']) ){
			$show_plugin_pages = !empty($_REQUEST['page']) && preg_match('/^login\-with\-ajax/', $_REQUEST['page']);
			$show_network_admin = is_network_admin() && !empty($_REQUEST['page']) && preg_match('/^login\-with\-ajax/', $_REQUEST['page']);
			// show review nudge
			if( !empty($data['admin-modals']['review-nudge']) && $data['admin-modals']['review-nudge'] < time() ) {
				if(true ) {
					// check it hasn't been shown more than 1 times, if so revert it to a regular admin notice
					if( empty($data['admin-modals']['review-nudge-count']) ){
						$data['admin-modals']['review-nudge-count'] = 0;
					}
					if( $data['admin-modals']['review-nudge-count'] < 1 ) {
						// enqueue script and load popup action
						if ( ! wp_script_is( 'meta-tag-manager-admin' ) ) {
							\Meta_Tag_Manager_Admin::scripts('force_load');
						}
						add_filter( 'admin_footer', array( static::class, 'review_popup' ) );
						$data['admin-modals']['review-nudge-count']++;
						update_site_option('mtm_admin_notices', $data);
					}else{
						// move it into a regular admin notice and stop displaying
						unset($data['admin-modals']['review-nudge-count']);
						unset($data['admin-modals']['review-nudge']);
						update_site_option('mtm_admin_notices', $data);
						// notify user of new update
						$Admin_Notice = new Admin_Notice(array( 'name' => 'review-nudge', 'who' => 'admin', 'where' => 'all' ));
						Admin_Notices::add($Admin_Notice, is_multisite());
					}
				}
			}
			// promo
			// check if pro license is active
			/*
			$pro_license_active = defined('mtm_PRO_VERSION');
			if( $pro_license_active ){
				$key = get_option('mtm_pro_api_key');
				$pro_license_active = !(empty($key['until']) || $key['until'] < strtotime('+10 months'));
			}
			*/
			if( time() < 1711962000 && !empty($data['admin-modals']['promo-popup']) /*&& !$pro_license_active*/) {
				if( $data['admin-modals']['promo-popup'] == 1 || ($data['admin-modals']['promo-popup'] == 2 ) ) {
					// enqueue script and load popup action
					if( empty($data['admin-modals']['promo-popup-count']) ){
						$data['admin-modals']['promo-popup-count'] = 0;
					}
					if( $data['admin-modals']['promo-popup-count'] <= 1 ) {
						if ( ! wp_script_is( 'meta-tag-manager-admin' ) ) {
							\Meta_Tag_Manager_Admin::scripts('force_load');
						}
						add_filter('admin_footer', array( static::class, 'promo_popup' ));
						$data['admin-modals']['promo-popup-count']++;
						update_site_option('mtm_admin_notices', $data);
					}else{
						// move it into a regular admin notice and stop displaying
						unset($data['admin-modals']['promo-popup-count']);
						unset($data['admin-modals']['promo-popup']);
						update_site_option('mtm_admin_notices', $data);
						// notify user of new update
						$Admin_Notice = new Admin_Notice(array( 'name' => 'promo-popup', 'who' => 'admin', 'where' => 'all' ));
						Admin_Notices::add($Admin_Notice, is_multisite());
					}
				}
			}
		}
	}
	
	public static function review_popup(){
		// check admin data and see if show data is still enabled
		?>
		<div class="mtm-modal mtm-modal-overlay mtm-admin-modal mtm-wrapper mtm-bones" id="mtm-review-nudge" data-nonce="<?php echo wp_create_nonce('mtm-review-nudge'); ?>">
			<div class="mtm-modal-popup mtm pixelbones">
				<header>
					<div class="mtm-modal-title"><?php esc_html_e('Enjoying Meta Tag Manager? Help Us Improve!', 'meta-tag-manager'); ?></div>
				</header>
				<div class="mtm-modal-content has-image">
					<div>
						<p><?php esc_html_e('Pardon the interruption... we hope you\'re enjoying Meta Tag Manager, and if so, we\'d really appreciate a positive review on the wordpress.org repository!', 'meta-tag-manager'); ?></p>
						<p><?php esc_html_e('Meta Tag Manager has been maintained, developed and supported for free since it was released in 2008, positive reviews are one way that help us keep going.', 'meta-tag-manager'); ?></p>
						<p><?php esc_html_e('If you could spare a few minutes, we would appreciate it if you could please leave us a review.', 'meta-tag-manager'); ?></p>
					</div>
					<div class="image">
						<img src="<?php echo MTM_DIR_URL . '/images/star-halo.svg'; ?>" style="width:75%; opacity:0.7;">
						<img src="<?php echo MTM_DIR_URL . '/images/logo.png'; ?>">
					</div>
				</div><!-- content -->
				<footer class="mtm-submit-section input">
					<div>
						<a href="https://wordpress.org/support/plugin/meta-tag-manager/reviews/?filter=5#new-topic-0" class="button button-primary input" target="_blank" style="margin:10px auto; --accent-color:#429543; --accent-color-hover:#429543;">
							Leave a Review
							<img src="<?php echo MTM_DIR_URL . '/images/five-stars.svg'; ?>" style="max-height:10px; width:50px; margin-left:5px;">
						</a>
						<button class="button button-secondary dismiss-modal"><?php esc_html_e('Dismiss Message', 'meta-tag-manager'); ?></button>
					</div>
				</footer>
			</div><!-- modal -->
		</div>
		<?php
		static::output_js();
	}
	
	public static function review_notice(){
		ob_start();
		?>
		<div style="display: grid; grid-template-columns: 80px auto; grid-gap: 20px;">
			<div style="align-self: center; text-align: center; padding-left: 10px;">
				<img src="<?php echo MTM_DIR_URL . '/images/star-halo.svg'; ?>" style="width:75%; opacity:0.7;">
				<img src="<?php echo MTM_DIR_URL . '/images/logo.png'; ?>" style="width: 100%;">
			</div>
			<div>
				<p><?php esc_html_e('Pardon the interruption... we hope you\'re enjoying Meta Tag Manager, and if so, we\'d really appreciate a positive review on the wordpress.org repository!', 'meta-tag-manager'); ?></p>
				<p>
					<?php esc_html_e('Meta Tag Manager has been maintained, developed and supported for free since it was released in 2008, positive reviews are one that help us keep going.', 'meta-tag-manager'); ?>
					<?php esc_html_e('If you could spare a few minutes, we would appreciate it if you could please leave us a review.', 'meta-tag-manager'); ?>
				</p>
				<a href="https://wordpress.org/support/plugin/meta-tag-manager/reviews/?filter=5#new-topic-0" class="button button-primary input" target="_blank" style="margin:10px 10px 10px 0; --accent-color:#429543; --accent-color-hover:#429543;">
					Leave a Review
					<img src="<?php echo MTM_DIR_URL . '/images/five-stars.svg'; ?>" style="max-height:10px; width:50px; margin-left:5px;">
				</a>
				<a href="<?php echo esc_url( admin_url('admin-ajax.php?action=mtm_dismiss_admin_notice&notice=review-nudge&redirect=1&nonce='.wp_create_nonce('mtm_dismiss_admin_noticereview-nudge') ) ); ?>" class="button button-secondary" style="margin:10px 0;"><?php esc_html_e('Dismiss', 'meta-tag-manager'); ?></a>
			</div>
		</div><!-- content -->
		<?php
		return ob_get_clean();
	}
	
	public static function promo_popup(){
		// check admin data and see if show data is still enabled
		?>
		<div class="mtm-modal mtm-modal-overlay mtm-admin-modal mtm-wrapper mtm-bones" id="mtm-promo-popup" data-nonce="<?php echo wp_create_nonce('mtm-promo-popup'); ?>">
			<div class="mtm-modal-popup mtm pixelbones">
				<header>
					<a class="mtm-close-modal dismiss-modal" href="#"></a><!-- close modal -->
					<h4 class="mtm-modal-title">Makers of Meta Tag Manager - Limited Time 50% Off!</h4>
				</header>
				<div class="mtm-modal-content has-image" style="--font-size:16px;">
					<div>
						<p>Pardon the interruption.... We hope you're enjoying the Meta Tag Manager plugin, all our plugins help fund and maintain our free plugins, get great deals whilst funding further development!</p>
						<p>We'd like to make sure you're aware some limited time deals for our other plugins. Purchase a license, renew or upgrade and get up to 50% off!</p>
						<ul>
							<li><a href="https://em.cm/em-mtm-promo-n" target="_blank">Events Manager Pro</a></li>
							<li><a href="https://em.cm/lwa-mtm-promo-n" target="_blank">Login With AJAX Pro</a></li>
							<li><a href="https://em.cm/mtm-promo-n" target="_blank">Meta Tag Manager Pro</a></li>
						</ul>
					</div>
					<div class="image">
						<img src="<?php echo MTM_DIR_URL . '/images/logo.png'; ?>">
					</div>
				</div><!-- content -->
				<footer class="mtm-submit-section input">
					<div>
						<button class="button button-secondary dismiss-modal">Dismiss Notice</button>
					</div>
				</footer>
			</div>
		</div>
		<?php
		static::output_js();
	}
	
	public static function promo_notice(){
		ob_start();
		?>
		<div style="display: grid; grid-template-columns: 80px auto; grid-gap: 20px;">
			<div style="text-align: center; padding-left: 10px; padding-top:10px;">
				<img src="<?php echo MTM_DIR_URL . '/images/logo.png'; ?>" style="width: 100%;">
			</div>
			<div>
				<p>Pardon the interruption.... We hope you're enjoying the Meta Tag Manager plugin, all our plugins help fund and maintain our free plugins, get great deals whilst funding further development!</p>
				<p>We'd like to make sure you're aware some limited time deals for our other plugins. Purchase a license, renew or upgrade and get up to 50% off!</p>
				<ul>
					<li><a href="https://em.cm/em-mtm-promo" target="_blank">Events Manager Pro</a></li>
					<li><a href="https://em.cm/lwa-mtm-promo" target="_blank">Login With AJAX Pro</a></li>
					<li><a href="https://em.cm/mtm-promo" target="_blank">Meta Tag Manager Pro</a></li>
				</ul>
				<a href="<?php echo esc_url( admin_url('admin-ajax.php?action=mtm_dismiss_admin_notice&notice=promo-popup&redirect=1&nonce='.wp_create_nonce('mtm_dismiss_admin_noticepromo-popup'.get_current_user_id()) ) ); ?>" class="button button-secondary" style="margin:10px 0;"><?php esc_html_e('Dismiss', 'meta-tag-manager'); ?></a>
			</div>
		</div><!-- content -->
		<?php
		return ob_get_clean();
	}
	
	public static function output_js(){
		if( !static::$output_js ){
			?>
			<script>
				jQuery(document).ready(function($){
					// Modal Open/Close
					let openModal = function( modal, onOpen = null ){
						modal = jQuery(modal);
						modal.appendTo(document.body);
						setTimeout( function(){
							modal.addClass('active').find('.mtm-modal-popup').addClass('active');
							jQuery(document).triggerHandler('mtm_modal_open', [modal]);
							if( typeof onOpen === 'function' ){
								setTimeout( onOpen, 200); // timeout allows css transition
							}
						}, 100); // timeout allows css transition
					};
					let closeModal = function( modal, onClose = null ){
						modal = jQuery(modal);
						modal.removeClass('active').find('.mtm-modal-popup').removeClass('active');
						setTimeout( function(){
							if( modal.attr('data-parent') ){
								let wrapper = jQuery('#' + modal.attr('data-parent') );
								if( wrapper.length ) {
									modal.appendTo(wrapper);
								}
							}
							modal.triggerHandler('mtm_modal_close');
							if( typeof onClose === 'function' ){
								onClose();
							}
						}, 500); // timeout allows css transition
					}
					$('.mtm-admin-modal').each( function(){
						let modal = $(this);
						let ignore_event = false;
						openModal( modal );
						modal.on('mtm_modal_close', function(){
							// send AJAX to close
							if( ignore_event ) return false;
							$.post( '<?php echo esc_url(admin_url('admin-ajax.php')); ?>', { action : 'mtm-admin-popup-modal', 'dismiss':'close', 'modal':modal.attr('id'), 'nonce': modal.attr('data-nonce') });
						});
						modal.find('button.dismiss-modal').on('click', function(){
							// send AJAX to close
							ignore_event = true;
							closeModal(modal);
							$.post( '<?php echo esc_url(admin_url('admin-ajax.php')); ?>', { action : 'mtm-admin-popup-modal', 'dismiss':'button', 'modal':modal.attr('id'), 'nonce':modal.attr('data-nonce') });
						});
					});
				});
			</script>
			<?php
			static::$output_js = true;
		}
	}
	
	public static function ajax(){
		if( !empty($_REQUEST['modal']) && wp_verify_nonce($_REQUEST['nonce'], $_REQUEST['modal']) ){
			$action = sanitize_key( preg_replace('/^mtm\-/', '', $_REQUEST['modal']) );
			$data = is_multisite() ? get_site_option('mtm_admin_notices') : get_option('mtm_admin_notices');
			if( $_REQUEST['dismiss'] == 'button' || $data['admin-modals'][$action] === 2 ) {
				// disable the modal so it's not shown again
				unset($data['admin-modals'][$action]);
				if( !empty($data['admin-modals'][$action.'-count']) ) unset($data['admin-modals'][$action.'-count']);
				is_multisite() ? update_site_option('mtm_admin_notices', $data) : update_option('mtm_admin_notices', $data);
			}else{
				// limit popup to mtm pages only
				$data['admin-modals'][$action] = 2;
				is_multisite() ? update_site_option('mtm_admin_notices', $data) : update_option('mtm_admin_notices', $data);
			}
		}
	}
}
Admin_Modals::init();