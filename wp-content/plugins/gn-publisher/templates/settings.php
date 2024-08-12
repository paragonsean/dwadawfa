<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$tab  = 'gn-intro';
if( !empty( $_GET['tab'] ) ) {
  $tab  = sanitize_text_field( wp_unslash( $_GET['tab'] ) ); 
}

?>
<div class="wrap">
  <div class="gn-container">
  
    <h1><a href="https://gnpublisher.com/" target="_blank"><img  class="gn-logo" src=<?php echo GNPUB_URL . '/assets/images/logo.png' ?> title="<?php esc_html_e( 'GN Publisher', 'gn-publisher' ); ?>"/></a></h1>
  </div>
<?php 
if ( defined('GNPUB_PRO_VERSION') ) { 
  $license_info = get_option("gnpub_pro_upgrade_license"); 
  $license_key_status = $license_key = '';
    if(isset($license_info['pro']['license_key'])){
      $license_key  = $license_info['pro']['license_key'];
      $replace = ''; for ($i=0; $i < strlen($license_key)-4; $i++) { $replace .= '*'; }
      $license_key = substr_replace($license_key, $replace, 0, strlen($license_key)-4);
      $license_key_status = $license_info['pro']['license_key_status'];
    } 
  if($license_key_status != 'active'){
    echo '<div class="gnpu-license-notice">'.__( 'Thank You For installing ', 'gn-publisher' ).'<a href="https://gnpublisher.com/" target="_blank">'.__( 'GN PUBLISHER PRO', 'gn-publisher' ).'</a>, '.__( 'please activate the license key to receive regular updates.', 'gn-publisher' ).'</div>
    ';
  } 
} 
?>
  <div class="gn-tab">
  <button class="gn-tablinks <?php echo esc_attr( $tab == 'gn-intro' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-intro')" id="defaultOpen" data-link-id="gn-intro"><?php echo esc_html__('Dashboard', 'gn-publisher') ?></button>
  <button class="gn-tablinks <?php echo esc_attr( $tab == 'gn-google-feed' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-google-feed')" id="gn-feed" data-link-id="gn-google-feed"><?php echo esc_html__('Google News Feed Setup', 'gn-publisher') ?></button>
  <button class="gn-tablinks <?php echo esc_attr( $tab == 'gn-features' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-features')" data-link-id="gn-features"><?php echo esc_html__('Features', 'gn-publisher') ?></button>
  <button class="gn-tablinks <?php echo esc_attr( $tab == 'gn-compatibility' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-compatibility')" data-link-id="gn-compatibility"><?php echo esc_html__('Compatibility', 'gn-publisher') ?></button>
  <button class="gn-tablinks <?php echo esc_attr( $tab == 'gn-troubleshooting' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-troubleshooting')" data-link-id="gn-troubleshooting"><?php echo esc_html__('Troubleshooting', 'gn-publisher') ?></button>
  <button class="gn-tablinks <?php echo esc_attr( $tab == 'gn-services' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-services')" data-link-id="gn-services"><?php echo esc_html__('Services', 'gn-publisher') ?></button>
  <?php if(defined('GNPUB_PRO_VERSION')){ ?>
    <button class="gn-tablinks gn-license-btn <?php echo esc_attr( $tab == 'gn-license' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-license')" data-link-id="gn-license"><?php echo esc_html__('License', 'gn-publisher') ?> <?php
    if($license_key_status != 'active'){
    echo '<span style="color: red;">!</span>';
    }  
    ?>
  </button>
  <?php } else { ?>
    <button class="gn-tablinks gnpub-upgrade <?php echo esc_attr( $tab == 'gn-upgrade' || $tab == 'welcome' ? $tab.' active' : ''); ?>" onclick="openTab(event, 'gn-upgrade')" data-link-id="gn-upgrade"><?php echo esc_html__('Upgrade to PRO', 'gn-publisher') ?></button>
    <!-- <button class="gn-tablinks gnpub-upgrade"><a target="_blank" href="https://gnpublisher.com/pricing/#pricing">Upgrade to PRO</a></button> -->
    <?php } ?>
    <button class="gn-tablinks <?php echo esc_attr( $tab == 'gn-help' ? 'active' : ''); ?>" onclick="openTab(event, 'gn-help')" data-link-id="gn-help"><?php echo esc_html__('Help &amp; Support', 'gn-publisher') ?></button>
</div>

<div id="gn-intro" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-intro' ? 'gnpub-show' : 'gnpub-d-none'); ?>">
   
  <p><?php
      printf(
        __( '<p> This plugin was created by Chris Andrews, a Platinum Level Product Expert on the Google News Publisher Help forum, the original creator of <a href="%1$s" target="_blank">GN Publisher</a>.</p>', 'gn-publisher' ),
        'https://gnpublisher.com/'
      );
  ?></p>

  <p><?php
      printf(
        __( 'GN Publisher is a WordPress plugin designed to output RSS feeds that comply with the <a href="%1$s" target="_blank">Google News RSS Feed Technical Requirements</a> for inclusion in the <a href="%2$s" target="_blank">Google News Publisher Center</a>.', 'gn-publisher' ),
        'https://support.google.com/news/publisher-center/answer/9545420?hl=en',
        'https://publishercenter.google.com/'
      );
  ?></p>

  <p><?php esc_html_e( 'The plugin addresses common issues publishers experience when using the Google News Publisher Center, including:', 'gn-publisher' ); ?></p>
 
    <ul style="list-style-type:circle;padding-left: 40px;">
      <li><?php esc_html_e( 'Incomplete articles', 'gn-publisher' ); ?></li>
      <li><?php esc_html_e( 'Duplicate images', 'gn-publisher' ); ?></li>
      <li><?php esc_html_e( 'Missing images or media', 'gn-publisher' ); ?></li>
      <li><?php esc_html_e( 'Missing content (usually social media/Instagram embeds)', 'gn-publisher' ); ?></li>
      <li><?php esc_html_e( 'Title errors (missing or repeated title)', 'gn-publisher' ); ?></li>
      <li><?php esc_html_e( 'Cached RSS feeds causing slow updating', 'gn-publisher' ); ?></li>
      <li><?php esc_html_e( 'Delayed crawling by Google', 'gn-publisher' ); ?></li>
    </ul>
</div>

<div id="gn-google-feed" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-google-feed' ? 'gnpub-show' : 'gnpub-d-none'); ?>">
   
   <p><?php esc_html_e( 'Once installed and activated, you can find your GN Publisher RSS feeds at:', 'gn-publisher' ); ?></p>

    <ul>
    <?php 

  /////// display feed urls, @since 1.0.2 -ca ///////////////////
      $permalinks_enabled = ! empty( get_option( 'permalink_structure' ) );
      $feed_url=esc_url( $permalinks_enabled ? trailingslashit( home_url() ) . 'feed/gn' : add_query_arg( 'feed', 'gn', home_url() ) );
      echo '<li><input type="text" class="gn-input" value="'.$feed_url.'" id="gn-feed-0" size="60" readonly>
      <div class="gn-tooltip">
      <button class="gn-btn" onclick="gn_copy('."'gn-feed-0'".')" onmouseout="gn_out('."'gn-feed-0'".')">
        <span class="gn-tooltiptext" id="gn-feed-0-tooltip">Copy URL</span>
        Copy
        </button>';
      echo '</div>';
      if(!defined('GNPUB_PRO_VERSION')){ ?>
          <a id="gnpub_cpost_type_config" class="gnpub-chf-btn" onclick="gnpubDisplayProBtn()"> <?php echo esc_html_e('Customize Home Feed', 'gn-publisher') ?> </a>
          <a class="gn-publisher-pro-btn gn-publisher-pro-btn-f-setup gnpub-d-none"  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
        <?php }else{ ?>
          <a id="gnpub_cpost_type_config" class="gnpub-chf-btn" onclick="gnpubDisplayCptModal()"><?php esc_html_e('Customize Home Feed', 'gn-publisher'); ?> </a>
      <?php
      } 
      echo '</li>';
      $categories = get_categories(); 
      foreach( $categories as $category ) {
        $gn_category_link = get_category_link( $category->term_id );

        //Fix for Feed Url link if category is hidden by adding (.) in category base in wordpress permalinks section
        $gn_category_link = str_replace('/./','/',$gn_category_link); 

        /* Fix Feed Url when user have added custom text in custom permalink (Ex:'lifestyle/%postname%') 
           and Yoast SEO have removed category base 
        */
        $permalink_structure=get_option('permalink_structure');
        if ( defined( 'WPSEO_VERSION' ) && is_callable( array( 'WPSEO_Options', 'get' ) ) && WPSEO_Options::get( 'stripcategorybase' ) == true && !empty($permalink_structure)) {
          $permalink_prepend = "";
          if(strlen($permalink_structure)>3)
          {
            $permalink_array=explode('/%',$permalink_structure);
            if($permalink_array && count($permalink_array)>1)
            {
              $permalink_prepend =trailingslashit($permalink_array[0]);
            }
          }
          $gn_category_link = str_replace($permalink_prepend,'/',$gn_category_link);
        }

        $gn_category_link = $permalinks_enabled ? trailingslashit( $gn_category_link ) . 'feed/gn' : add_query_arg( 'feed', 'gn', $gn_category_link );
        echo '<li><input type="text" class="gn-input" value="'.esc_url( $gn_category_link ).'" id="gn-feed-'.esc_attr($category->term_id).'" size="60" readonly>
      <div class="gn-tooltip">
      <button class="gn-btn" onclick="gn_copy('."'gn-feed-".esc_attr($category->term_id)."'".')" onmouseout="gn_out('."'gn-feed-".esc_attr($category->term_id)."'".')">
        <span class="gn-tooltiptext" id="gn-feed-'.esc_attr($category->term_id).'-tooltip">'.__( 'Copy URL', 'gn-publisher' ).'</span>
        Copy
        </button>
      </div></li>';
      
      } 
    ?>
    </ul>
<p><?php esc_html_e( 'You are not required to use all of the feeds listed above. Just use the ones you want to include in your Publisher Center. Each feed will contain the thirty most recently updated articles in its category.', 'gn-publisher' ); ?></p>

<p><?php esc_html_e( 'If you have AMP on your site, the Publisher Center will render the AMP version. If you do not have AMP available, the Publisher Center will usually generate your articles from the feed.', 'gn-publisher' ); ?></p>

  <p><?php esc_html_e( 'Be sure to click that blue "Save" button in the upper right hand corner of the Publisher Center to save your changes (it\'s surprisingly easy to miss). After saving, wait ten minutes for Google to fetch your feed and render your articles. Then reload the entire page using your browser\'s reload/refresh button before checking to see if your articles appear in the Publisher Center.', 'gn-publisher' ); ?></p>

  <p><?php esc_html_e( 'After the initial setup, GN Publisher will ping Google with an alert each time your feed is updated.', 'gn-publisher' ); ?></p>

  <?php if(!defined('GNPUB_PRO_VERSION')){ ?>
<div class="info gnpub-content-stolen-badge">
  <div class="gnpub-badge-left"><a href="https://gnpublisher.com/" target="_blank"><img  class="gn-logo" src=<?php echo GNPUB_URL . '/assets/images/gn-logo-mini.png' ?> title="<?php esc_html_e( 'GN Publisher', 'gn-publisher' ); ?>"/></a></div>
  <div class="gnpub-badge-right"><p><?php echo esc_html__('For feed content protection, upgrade to Premium.', 'gn-publisher') ?></p></div>
  <div class="gnpub-badge-right-btn"><a class="gn-publisher-pro-btn " target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a></div>
</div>
<?php } 
do_action('gnpub_pro_cpt_form'); 
?>
</div>


<div id="gn-troubleshooting" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-troubleshooting' ? 'gnpub-show' : 'gnpub-d-none'); ?>">

<div class="gn-menu">
    <div class="gn-question">
      <input type="checkbox" id="type1" class="gn-accordion">
      <label for="type1">
      <?php echo esc_html__('There are no articles in this section', 'gn-publisher') ?>
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links1">
        <li>
          <p><?php esc_html_e( 'If you are getting the dreaded "There are no articles in this section" message in the Publisher Center:', 'gn-publisher' ); ?></p>
           <p><?php esc_html_e( 'Refresh the section in the Publisher Center. Wait 10 to 15 minutes, then reload the entire page using your browser\'s "reload" button and recheck to see if articles appear.', 'gn-publisher' ); ?></p>
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type2" class="gn-accordion">
      <label for="type2">
      <?php echo esc_html__('Refreshed the page but again the same result', 'gn-publisher') ?>
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links2">
        <li>
          <p><?php esc_html_e( 'If you\'ve refreshed the page in the Publisher Center and continue to get the same results, visit the URL you entered for the section and make sure there are articles included in the feed.', 'gn-publisher' ); ?></p>
           <p><?php esc_html_e( 'If you get a 404 or "missing" page when visiting the feed url, please review the notes in the "feed urls" section above and If there are no articles in the feed, please make sure there are articles published in that section (category) within the last 30 days.', 'gn-publisher' ); ?></p>
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type3" class="gn-accordion">
      <label for="type3">
      <?php echo esc_html__('If the url works then what to do', 'gn-publisher') ?>
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links3">
        <li>
          <?php $last_fetch=( is_null( $last_google_fetch ) ) ? __( 'None recorded.', 'gn-publisher' ) : $last_google_fetch;
         $last_websub_ping = ( is_null( $last_websub_ping ) ) ? __( 'None recorded.', 'gn-publisher' ) : $last_websub_ping; 
          ?>
         <p><?php echo esc_html__('➔', 'gn-publisher').'<b>'.esc_html__('Most Recent Feedfetcher Fetch: '.$last_fetch.'(if testing, refresh this page for most recent fetch time)', 'gn-publisher').'</b><br/>'.esc_html__('If the "Most Recent Feedfetcher fetch" is "None recorded" or the date is more than 24 hours old, it\'s likely that your host or firewall is blocking Google\'s feed crawler, Feedfetcher. Because Feedfetcher is not a well-known bot and doesn\'t follow some of the standard crawler procedures, it is often mistakenly blocked by hosting companies and firewalls. Ask your hosting company or server administrator to whitelist the user-agent "Feedfetcher-Google". Note: If you are using AWS Cloudfront, Amazon does not pass the user-agent through to GN Publisher, so the "Most Recent Feedfetcher Fetch" timestamp will not work for you.', 'gn-publisher'); ?></p>
         <p><?php echo esc_html__('➔', 'gn-publisher').'<b>'.esc_html__('Most Recent Update Ping Sent: '.$last_websub_ping.' (if testing, refresh this page for most recent ping time)', 'gn-publisher').'</b><br/>'.esc_html__('When you publish or update a post, GN Publisher pings Google to let them know there is an update to one of your feeds. The "Most Recent Update Ping" indicates when the most recent ping was sent. Google normally fetches the feed soon thereafter (often within a minute).', 'gn-publisher'); ?></p>
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type4" class="gn-accordion">
      <label for="type4">
      <?php echo esc_html__('How to run RSS Feed Validator', 'gn-publisher') ?>
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links4">
        <li>
          <p><?php echo esc_html__( '➔ The validator may validate but warn about iframe and script tags - those are okay for our purposes.','gn-publisher').'<br/>';
   echo esc_html__( '➔ If the validator does not validate, or validates but warns of "invalid html" (for example, a "missing p tag"), those issues can cause the crawler to not accept the feed. These errors are sometimes caused by poorly coded themes or plugins and require further investigation to correct. The p tag issue is a common one that is often caused by a figure tag or blockquote tag (or other block level element) being inside a paragraph, which is not valid html.','gn-publisher').'<br/>';
   echo esc_html__( '➔ If some Publisher Center sections are being fetched okay and others are reporting "no articles" - it\'s likely an html error that is included in an article on the specific feed that isn\'t loading properly in the Publisher Center.', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type5" class="gn-accordion">
      <label for="type5">
      <?php echo esc_html__('Missing Images', 'gn-publisher') ?> 
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links5">
        <li>
          <p><?php echo esc_html__( 'The Publisher Center requires that large images be used as the featured image - at least 800px on the shortest side. GN Publisher will try to use your original image, which is generally the largest. If you upload a featured image that is smaller than 800px on its shortest side, it might not appear with the article in the Publisher Center.','gn-publisher').'<br/>';
          echo  esc_html__( 'Note - the Publisher Center preview pane can only display .jpg and .png image files. If you are using a CDN like CloudFlare or KeyCDN, even if you have the images set up correctly, the CDN may serve them as WebP files. That will cause the images to not be displayed, or be displayed inconsistently, in the preview pane. If you are experiencing this, go the the "Review and Publish" tab in the Publisher Center, subscribe to your publication if you haven\'t already, and then click on link for your publication and make sure the images are displayed correctly there. If they are displayed on your publication in Google News, you can ignore them not being in the preview pane.','gn-publisher').'<br/>';
        ?></p>
           
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type6" class="gn-accordion">
      <label for="type6">
      <?php echo esc_html__('Missing Media', 'gn-publisher') ?>
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links6">
        <li>
          <p><?php esc_html_e( 'Social media embeds that are included in your articles should also appear as part of the article in your Publisher Center. GN Publisher is designed to properly adjust the embeds for use in the Publisher Center. If your embeds don\'t appear as they should, please contact me through the GN Publisher support forum on WordPress.org', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
    <div class="gn-question">
      <input type="checkbox" id="type7" class="gn-accordion">
      <label for="type7">
      <?php echo esc_html__('General Info', 'gn-publisher') ?>
        <div class="gn-icon">
          <span aria-hidden="true"></span>
        </div>
      </label>
      <ul id="links7">
        <li>
          <p><?php echo esc_html__( '➔ Be aware that Google has certain Content Policies for sites included on Google News properties. More information about applying is available on the Google News Publisher Help Center.','gn-publisher').'<br/>';

echo esc_html__( '➔ You\'ll need to meet additional requirements in the Publisher Center, such as verifying your domain, selecting an appropriate publication name, and setting up your logos correctly.','gn-publisher').'<br/>';

echo esc_html__( '➔ Because of the huge number of ways that publishers, plugins, and themes can manipulate WordPress posts, I can\'t guarantee that this plugin will result in the technical requirements being met.', 'gn-publisher' ); ?></p>
           
        </li>
      </ul>
    </div>
  </div>

  <p><?php echo esc_html__('If the above information does not seems to help you can also contact us from', 'gn-publisher') ?>  <a href="https://gnpublisher.com/contact-us/" target="_ blank">https://gnpublisher.com/contact-us</a></p>
</div>

<div id="gn-help" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-help' ? 'gnpub-show' : 'gnpub-d-none'); ?>">
<div class="gn-flex-container">
<div class="gn-left-side">
<p><?php echo esc_html__('We are dedicated to provide Technical support &amp; Help to our users. Use the below form for sending your questions. ', 'gn-publisher') ?></p>
<p><?php echo esc_html__('You can also contact us from', 'gn-publisher') ?> <a href="https://gnpublisher.com/contact-us/" target="_blank">https://gnpublisher.com/contact-us/</a>.</p>

<div class="gn_support_div_form" id="technical-form">
            <ul>
                <li>
                  <label class="gn-support-label"><?php echo esc_html__('Email', 'gn-publisher') ?><span class="gn-star-mark">*</span></label>
                   <div class="support-input">
                      
                      <input type="text" id="gn_query_email" name="gn_query_email" size="47" placeholder="Enter your Email" required="">
                   </div>
                </li>
                
                <li>
                    <label class="gn-support-label"><?php echo esc_html__('Query', 'gn-publisher') ?><span class="gn-star-mark">*</span></label>                    
                   
                    <div class="support-input"><textarea rows="5" cols="50" id="gn_query_message" name="gn_query_message" placeholder="Write your query"></textarea>
                    </div>
                
                  
                </li>
                
                <li><button class="button button-primary gn-send-query"><?php echo esc_html__('Send Support Request', 'gn-publisher') ?></button></li>
            </ul>            
                
             
            <div class="clear"> </div>
                    <span class="gn-query-success gn-result gn-hide"><?php echo esc_html__('Message sent successfully, Please wait we will get back to you shortly', 'gn-publisher') ?></span>
                    <span class="gn-query-error gn-result gn-hide"><?php echo esc_html__('Message not sent. please check your network connection', 'gn-publisher') ?></span>
            </div>
</div>

<div class="gn-right-side">
<div class="gn-bio-box" id="gn_Bio">
                <h1><?php echo esc_html__('Vision &amp; Mission', 'gn-publisher') ?></h1>
                <p class="gn-p"><?php echo esc_html__('We strive to provide the Google News Publisher in the world.', 'gn-publisher') ?></p>
              <p class="gn_boxdesk"> <?php echo esc_html__('Delivering a good user experience means a lot to us, so we try our best to reply each and every question.', 'gn-publisher') ?></p>
           </div>
</div>


  </div>
 
  

  
</div>

<div id="gn-services" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-services' ? 'gnpub-show' : 'gnpub-d-none'); ?>">

<div class="gn-flex-container-services">
  <div class="gn-service-card first">
      <div class="gn-service-card-left">
      <img src="<?php echo GNPUB_URL . '/assets/images/google-news.png'?>" width="128px" height="128px">
    </div>
    <div class="gn-service-card-right">
      <h3 class="gn-service-heading"><?php echo esc_html__('Google News Setup & Audit', 'gn-publisher') ?></h3>
    <p><?php echo esc_html__('You can get thousands of clicks to your site from Google News. We can set up Google news for your website and perform regular audits.', 'gn-publisher') ?></p>
    <a target="_blank" href="https://gnpublisher.com/services/google-news-setup-audit-service/#pricing" class="gn-btn-primary button button-primary"> <?php esc_html_e('View Pricing', 'gn-publisher');?></a><a href="https://gnpublisher.com/services/google-news-setup-audit-service/" target="_blank" class="gn-btn gn-btn-learnmore button"><?php esc_html_e('Learn More', 'gn-publisher');?></a>
    </div>
  </div>
  <div class="gn-service-card second">
  <div class="gn-service-card-left">  
    <img src="<?php echo GNPUB_URL . '/assets/images/support.png'?>" width="128px" height="128px">  
  </div>
  <div class="gn-service-card-right">    
  <h3 class="gn-service-heading"><?php echo esc_html__('Dedicated Developer for Website', 'gn-publisher') ?></h3>
  <p><?php echo esc_html__('Our dedicated developers will continuously monitor your website and make sure its up and running without any issue.', 'gn-publisher') ?></p>  
  <a target="_blank" href="https://gnpublisher.com/services/dedicated-developer-for-website-search-console-maintenance-service/#pricing" class="gn-btn-primary button button-primary"><?php echo esc_html__('View Pricing', 'gn-publisher') ?></a><a href="https://gnpublisher.com/services/dedicated-developer-for-website-search-console-maintenance-service/" target="_blank" class="gn-btn gn-btn-learnmore button"><?php echo esc_html__('Learn More', 'gn-publisher') ?></a>
  </div>
  </div>
  
  <div class="gn-service-card third">
  <div class="gn-service-card-left">
    <img src="<?php echo GNPUB_URL . '/assets/images/google.png'?>" width="128px" height="128px">
  </div>
  <div class="gn-service-card-right">
    <h3 class="gn-service-heading"><?php echo esc_html__('Search Console Maintenance', 'gn-publisher') ?>
    </h3>
    <p>  <?php echo esc_html__('We will manage your all Google Search Console problems because even after a webpage gets indexed, issues can happen.', 'gn-publisher') ?></p>
<a target="_blank" href="https://gnpublisher.com/services/search-console-maintenance-service/#pricing" class="gn-btn-primary button button-primary"><?php esc_html_e('View Pricing', 'gn-publisher');?></a><a href="https://gnpublisher.com/services/search-console-maintenance-service/" target="_blank" class="gn-btn gn-btn-learnmore button">Learn More</a>
  </div>
  </div>
 
  </div>
</div>

<?php 
$default_options=array('gnpub_enable_google_revenue_manager'=>false, 'gnpub_enable_google_revenue_manager' => '', "gnpub_google_rev_snippet_name" => "");
$gnpub_options = get_option( 'gnpub_new_options', $default_options );
$gnpub_enable_google_revenue_manager = isset($gnpub_options['gnpub_enable_google_revenue_manager'])?$gnpub_options['gnpub_enable_google_revenue_manager']:false;
$gnpub_google_rev_snippet = isset($gnpub_options['gnpub_google_rev_snippet']) ?  $gnpub_options['gnpub_google_rev_snippet'] : '';
$gnpub_google_rev_snippet_name = isset($gnpub_options['gnpub_google_rev_snippet_name']) ? $gnpub_options['gnpub_google_rev_snippet_name']: '';

?>
<div id="gn-features" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-features' ? 'gnpub-show' : 'gnpub-d-none'); ?>">

        <p>
    <form action="" method="post">
    <p>
    <table class="form-table">

      <tr>
        <th><?php esc_html_e( 'Google Revenue Manager', 'gn-publisher' ); ?></th>
        <td>
          <input type="checkbox" name="gnpub_enable_google_revenue_manager" id="gnpub_enable_google_revenue_manager" <?php checked( $gnpub_enable_google_revenue_manager, true ); ?> value="1" />
          <label for="gnpub_enable_google_revenue_manager"><?php esc_html_e( 'Increase revenue and improve reader engagement.', 'gn-publisher.' ); ?> &nbsp; <span class="gnpub-span-lrn-more"> <a target="_blank" style="text-decoration:none;" href="https://gnpublisher.com/docs/knowledge-base/how-to-enable-google-revenue-manager/"><?php esc_html_e( 'Learn More', 'gn-publisher' ); ?></a></span></label>
          
        </td>
      </tr>
      <tr id="gnpub_val_tr_revenue_snippname" style="display:none">
        <th><?php esc_html_e( 'Snippet Name', 'gn-publisher' ); ?></th>
        <td>
          <input type="text" name="gnpub_google_rev_snippet_name" id="gnpub_google_rev_snippet_name" value="<?php echo esc_attr($gnpub_google_rev_snippet_name); ?>" style="width: 40%;" placeholder="Name of snippet">
        </td>
      </tr>
      <tr id="gnpub_val_tr_revenue" style="display:none">
        <th><?php esc_html_e( 'Enter snippet code from Google', 'gn-publisher' ); ?></th>
        <td>
          <textarea cols="50" rows="6" placeholder="Paste the code snippet you generated in your Publisher Center here" name="gnpub_google_rev_snippet" value=""><?php echo esc_textarea($gnpub_google_rev_snippet); ?></textarea>
        </td>
      </tr>      
      <?php if(!defined('GNPUB_PRO_VERSION')){ ?>
       <tr>
        <th><?php esc_html_e( 'Feed Content Protection', 'gn-publisher' ); ?></th>
        <td>
        <input type="checkbox" name="gnpub-show-upgrd-toprem-btn-fch" class="gnpub-show-upgrd-toprem-btn-fch"/>
        <a class="gn-publisher-pro-btn"  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
        </td>
      </tr>
      <tr>
        <th><?php esc_html_e( 'Exclude Categories From Main Feed', 'gn-publisher' ); ?></th>
        <td>
        <input type="checkbox" name="gnpub-show-upgrd-toprem-btn-fch" class="gnpub-show-upgrd-toprem-btn-fch"/>
        <a class="gn-publisher-pro-btn "  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
        </td>
      </tr>

      <tr>
        <th><?php esc_html_e( 'Google News Sitemap', 'gn-publisher' ); ?></th>
        <td>
        <input type="checkbox" name="gnpub-show-upgrd-toprem-btn-fch" class="gnpub-show-upgrd-toprem-btn-fch"/>
        <a class="gn-publisher-pro-btn "  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
        </td>
      </tr> 
      
      <?php } else { 
     do_action('gnpub_pro_setup_form');
    
    } ?>
    </table>
    </p>
    <p>
    <input type="hidden" name="gnpub_form_tab" value="feature">
      <?php wp_nonce_field( 'save_gnpub_settings', '_wpnonce' ); ?>
      <input type="submit" name="save_gnpub_settings" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'gn-publisher' ); ?>" />
    </p>

    </form>
</p>
 
  </div>
  <div id="gn-compatibility" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-compatibility' ? 'gnpub-show' : 'gnpub-d-none'); ?>">
<?php if(!defined('GNPUB_PRO_VERSION')){ ?>
  <?php
    $default_options = array('gnpub_pp_flipboard_com' => false );
    $gnpub_options = get_option( 'gnpub_new_options', $default_options );
    $gnpub_pp_flipboard_com = $gnpub_options['gnpub_pp_flipboard_com'];
  ?>
  <form action="" method="post">
      <p>
    <table class="form-table">
      <tr>
        <th><?php esc_html_e( 'Flipboard.com', 'gn-publisher' ); ?></th>
        <td>
          <input type="checkbox" name="gnpub-show-upgrd-toprem-btn-fch" class="gnpub-show-upgrd-toprem-btn-fch"/>
        <a class="gn-publisher-pro-btn "  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
        </td>
      </tr>
      <tr>
        <th><?php esc_html_e( 'PublishPress Authors', 'gn-publisher' ); ?></th>
        <td>
          <input type="checkbox" name="gnpub-show-upgrd-toprem-btn-fch" class="gnpub-show-upgrd-toprem-btn-fch"/>
        <a class="gn-publisher-pro-btn "  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
        </td>
      </tr>
      <tr>
        <th><?php esc_html_e( 'Molongui Authorship', 'gn-publisher' ); ?></th>
        <td>
          <input type="checkbox" name="gnpub-show-upgrd-toprem-btn-fch" class="gnpub-show-upgrd-toprem-btn-fch"/>
        <a class="gn-publisher-pro-btn "  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
    
        </td>
      </tr>
      <tr>
        <th><?php esc_html_e( 'Translate Press', 'gn-publisher' ); ?></th>
        <td>
          <input type="checkbox" name="gnpub-show-upgrd-toprem-btn-fch" class="gnpub-show-upgrd-toprem-btn-fch"/>
        <a class="gn-publisher-pro-btn "  target="_blank" href="https://gnpublisher.com/pricing/#pricing"><?php echo esc_html__('Upgrade to Premium', 'gn-publisher') ?></a>
        </td>
      </tr>
    
      </table>
      </p> 
      <p class="submit">
      <input type="hidden" name="gnpub_form_tab" value="compat">
        <?php wp_nonce_field( 'save_gnpub_settings', '_wpnonce' ); ?>
        <input type="submit" name="save_gnpub_settings" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'gn-publisher' ); ?>" />
      </p>
  </form> 
  <?php } else { 
     do_action('gnpub_pro_compat_form');
    
    } ?>
    

  </div>
  <div id="gn-upgrade" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-upgrade' || $tab == 'welcome' ? 'gnpub-show' : 'gnpub-d-none'); ?>" style="text-align: center;">
<?php if(!defined('GNPUB_PRO_VERSION')){ ?>
  <p style="font-weight: bold;font-size: 30px;color: #000;"><?= esc_html_e( 'Thank You for using GN Publisher.', 'gn-publisher' ) ?></p>
        <p style="font-size: 18px;padding: 0 10%;line-height: 1.7;color: #000;"><?= esc_html_e( 'We strive to create the best GN Publisher solution in WordPress. Our dedicated development team does continuous development and innovation to make sure we are able to meet your demand.', 'gn-publisher' ) ?></p>
        <p style="font-size: 16px;font-weight: 600;color: #000;"><?= esc_html_e( 'Please support us by Upgrading to Premium version.', 'gn-publisher' ) ?></p>
        <a target="_blank" href="https://gnpublisher.com/pricing/#pricing/">
            <button class="button-gnp-ugrade" style="display: inline-block;font-size: 20px;">
                <span><?= esc_html_e( 'YES! I want to Support by UPGRADING.', 'gn-publisher' ) ?></span></button>
        </a>
        <a href="<?php echo add_query_arg('page', 'gn-publisher-settings', admin_url('options-general.php')); ?>"
           style="text-decoration: none;">
            <button class="button-gnp-ugrade1"
                    style="display: block;text-align: center;border: 0;margin: 0 auto;background: none;">
                <span style="cursor: pointer;"><?= esc_html_e( 'No Thanks, I will stick with FREE version for now.', 'gn-publisher' ) ?></span>
            </button>
        </a>
  <?php } ?>

  </div>
<div id="gn-license" class="gn-tabcontent <?php echo esc_attr( $tab == 'gn-license' ? 'gnpub-show' : 'gnpub-d-none'); ?>">
<?php if(defined('GNPUB_PRO_VERSION')){
   do_action('gnpub_pro_license_form');
 } 
 ?>
  </div>
</div>