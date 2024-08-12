<?php 
    
    if (!defined('ABSPATH')) exit;
    
    if (current_user_can('upload_files')) {

        global $wpdb;
        
        $mkgetpmsizeaction = $wpdb->get_var("SELECT Index_length + Data_length + Data_free FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{$wpdb->prefix}postmeta'");
        
        if(isset($_POST["hiddensubmit"])) {
            
            $retrieved_nonce = $_REQUEST['_wpnonce'];
            
            if (!wp_verify_nonce($retrieved_nonce, 'mk_pm_nonce_action' )){ 
                
                die( 'Failed security check' );}
            
            else {
            
                $mkpmclean1 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'usage%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean2 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'exclude%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean3 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'product%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean4 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'discount%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean5 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'coupon%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean6 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'individual%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean7 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'limit%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean8 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'expiry%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean9 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'free%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean10 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'minimum%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean11 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'maximum%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean12 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'customer%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean13 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'wpfc%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean14 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'user%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean15 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'slide%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean16 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'tiny%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean17 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'payment%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean18 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'billing%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean19 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'vcvSourceCssFileUrl%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean20 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'get%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean21 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'count%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean22 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'learn%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean23 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'wp-smpro-smush-data%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean24 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'date%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean25 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'thim%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean26 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'popup%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean27 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'tp%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean28 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'total%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean29 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'regency%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean30 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'tc-mega-menu%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean31 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'ampforwp-amp-on-off%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean32 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'linkedin%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean33 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'iyzico%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean34 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'twitter%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean35 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'onesignal%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean36 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'ea%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean37 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'panels%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean38 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'rs%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean39 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'text%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean40 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'dsq%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean41 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'order-pending%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean42 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'dsq%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean43 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'order-processing%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean44 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'order-completed%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean45 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'order-cancelled%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean46 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'tc%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean47 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'order-failed%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean48 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'vcv-be-editor%' AND meta_key NOT LIKE '\_%'";
                $mkpmclean49 = "DELETE {$wpdb->prefix}postmeta FROM {$wpdb->prefix}postmeta LEFT JOIN {$wpdb->prefix}posts ON ({$wpdb->prefix}postmeta.post_id = {$wpdb->prefix}posts.ID) WHERE ({$wpdb->prefix}posts.ID IS NULL)";
                $mkpmclean50 = "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key IN ('_edit_lock','_edit_last');";
                $mkpmclean51 = "DELETE {$wpdb->prefix}posts FROM {$wpdb->prefix}posts LEFT JOIN {$wpdb->prefix}posts child ON ({$wpdb->prefix}posts.post_parent = child.ID) WHERE ({$wpdb->prefix}posts.post_parent <> 0) AND (child.ID IS NULL);";
                $mkpmclean52 = "DELETE pm FROM {$wpdb->prefix}postmeta pm LEFT JOIN {$wpdb->prefix}posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL;";
                $mkpmclean53 = "OPTIMIZE TABLE {$wpdb->prefix}posts";
                $mkpmclean54 = "OPTIMIZE TABLE {$wpdb->prefix}postmeta";
                
                $wpdb->query($mkpmclean1, $mkpmclean2);
                $wpdb->query($mkpmclean3, $mkpmclean4);
                $wpdb->query($mkpmclean5, $mkpmclean6);
                $wpdb->query($mkpmclean7, $mkpmclean8);
                $wpdb->query($mkpmclean9, $mkpmclean10);
                $wpdb->query($mkpmclean11, $mkpmclean12);
                $wpdb->query($mkpmclean13, $mkpmclean14);
                $wpdb->query($mkpmclean15, $mkpmclean16);
                $wpdb->query($mkpmclean17, $mkpmclean18);
                $wpdb->query($mkpmclean19, $mkpmclean20);
                $wpdb->query($mkpmclean21, $mkpmclean22);
                $wpdb->query($mkpmclean23, $mkpmclean24);
                $wpdb->query($mkpmclean25, $mkpmclean26);
                $wpdb->query($mkpmclean27, $mkpmclean28);
                $wpdb->query($mkpmclean29, $mkpmclean30);
                $wpdb->query($mkpmclean31, $mkpmclean32);
                $wpdb->query($mkpmclean33, $mkpmclean34);
                $wpdb->query($mkpmclean35, $mkpmclean36);
                $wpdb->query($mkpmclean37, $mkpmclean38);
                $wpdb->query($mkpmclean39, $mkpmclean40);
                $wpdb->query($mkpmclean41, $mkpmclean42);
                $wpdb->query($mkpmclean43, $mkpmclean44);
                $wpdb->query($mkpmclean45, $mkpmclean46);
                $wpdb->query($mkpmclean47, $mkpmclean48);
                $wpdb->query($mkpmclean49, $mkpmclean50);
                $wpdb->query($mkpmclean51, $mkpmclean52);
                $wpdb->query($mkpmclean54, $mkpmclean53);
                   
                $mkcleanlastcheck = $wpdb->get_var("SELECT Index_length + Data_length + Data_free FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{$wpdb->prefix}postmeta'");
                
                $mkpmcleanfinally = $mkgetpmsizeaction - $mkcleanlastcheck;
                
                $mkpmecho = '<div class="alert alert-success" role="alert"> Great! Your: '. $mkpmcleanfinally  .' byte cleaned! </div>';
            
            }
        }
    }

?>

<div class="container-fluid p-5">
	<div class="container d-flex flex-row">
		<div class="col-6 p-3 d-flex flex-column justify-content-center">
			<div class="mk-postmeta-cleaner-title">
				<h3>Mk Postmeta Cleaner</h3>
			</div>
			<div class="mk-postmeta-cleaner-info">
				<p>This plugin removes any stuck, plugin residues, deleted or corrupted style files in your postmeta table. Don't forget to back up your database before using the plugin! You can only make a backup of the postmeta table.</p>
				<p>The lines cleaned by this plugin are: limit, expiry, free, minimum, maximum, customer, wpfc, user, slide, tiny, payment, billing, vcvSourceCssFileUrl, get, count, wp-smpro-smush-data, date, thim, popup +89 trash...</p>
				<p><b>Note: </b>This plugin only removes records whose post_id does not match, i.e. no longer used.</p>
			</div>
			<div class="mk-postmeta-cleaner-check-postmeta">
				Your postmeta size: <?php echo wp_kses_post($mkgetpmsizeaction) . ' Byte'; ?>
			</div>
		</div>
		<div class="col-6 p-3 d-flex flex-column align-items-center justify-content-center">
		    <div class="mk-postmeta-cleaner-banner d-flex flex-row justify-content-center mb-4">
		    <img id="mk-pm-clean-banner" style="width: 40%;" src="<?php echo plugins_url('mk-postmeta-cleaner/mk-postmeta-cleaner-banner.png') ?>">
		    </div>
		    <div class="mk-postmeta-cleaner-submit-area d-flex flex-column justify-content-center align-items-center">
		        <form id="mk-postmeta-clean-form" method="post" class="mb-3">
		            <input name="hiddensubmit" type="hidden" value="clean">
		            <input id="mkpmsubmit" type="submit" class="mk-clean-button btn btn-primary" value="Clean!">
		            <?php wp_nonce_field('mk_pm_nonce_action'); ?>
		        </form>
		        <?php echo wp_kses_post($mkpmecho) ?>
		    </div>
		</div>
	</div>
</div>
