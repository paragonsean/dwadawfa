<?php
/**
 * Plugin Name: Dan News API
 * Version: 1.0
 * Plugin uri: #
 * Author: WebfyMedia Technologies
 * Author uri: http://webfymedia.com
 * Description: This plugin allows to fetch news from worldwide to your website
**/

$url =  plugin_dir_url(__FILE__);
define('AWS_API_URL', $url);

class AWS_API {
	
	private $end_points = [
		'US' => 'webservices.amazon.com',
		'BR' => 'webservices.amazon.com.br',
		'CA' => 'webservices.amazon.ca',
		'CN' => 'webservices.amazon.cn',
		'DE' => 'webservices.amazon.de',
		'ES' => 'webservices.amazon.es',
		'FR' => 'webservices.amazon.fr',
		'IN' => 'webservices.amazon.in',
		'IT' => 'webservices.amazon.it',
		'JP' => 'webservices.amazon.co.jp',
		'MX' => 'webservices.amazon.com.mx',
		'UK' => 'webservices.amazon.co.uk'
	];
	
	function __construct(){
		add_action('admin_menu', array($this, 'init') );
		add_action('admin_init', array($this, 'aws_form_settings') );
		add_action('admin_head', array($this, 'setCss') );
		add_action('admin_enqueue_scripts', array($this, 'setScript') );
		
		add_action("wp_ajax_aws_fetch_products", array($this, 'aws_fetch_products') );
		add_action("wp_ajax_nopriv_aws_fetch_products", array($this, 'aws_fetch_products') );
		
		add_action("wp_ajax_aws_insert_posts", array($this, 'aws_insert_posts') );
		add_action("wp_ajax_nopriv_aws_insert_posts", array($this, 'aws_insert_posts') );
	}

	public function aws_fetch_products(){
		if( !wp_verify_nonce( $_REQUEST['_nonce'], "aws_api_nonce")) {
			  exit("No naughty business please");
		}
		
		$args = array();
		
		$keyword = $_POST['keyword'];
		$topic = $_POST['topic'];
		$country = $_POST['country'];
		$category = $_POST['category'];
		
		if(!empty($keyword)){
			$args['q'] = $keyword;
		}
		if(!empty($topic)){
			$args['topic'] = $topic;
		}
		if(!empty($category)){
			$args['category'] = $category;
		}
		if(!empty($country)){
			$args['country'] = $country;
		}
		
		$result = $this->getResult($args);
		
		header('Content-type: application/json');
      
        $output = '<input type="hidden" name="category" value="'.$keyword.'" />';
		
		$output .= '<table>';
		$output .= '<thead>';
		$output .= '<tr><th><input type="checkbox" id="checkall" /></th><th>Image</th><th>News Title</th><th></th></tr>';
		$output .= '</thead>';
		$output .= '<tbody>';
		foreach($result->articles as $key => $item){
			
			$output .= '<tr>';
			$output .= '<td><input class="checkitems" type="checkbox" name="check[]" value="'.$key.'" />';
			$output .= '<td><img width="90" class="img-responsive" src="'.$item->image.'" /></td>';
			$output .= '<td>'.$item->title.'</td>';
			$output .= '<td><input type="hidden" name="news[title][]" value="'.$item->title.'" /><input type="hidden" name="news[description][]" value="'.$item->content.'" /><input type="hidden" name="news[image][]" value="'.$item->image.'" /></td>';
			$output .= '</tr>';
			}
		$output .= '</tbody>';
		$output .= '<tfoot>';
		$output .= '<tr><th><input type="checkbox" id="checkall" /></th><th>Image</th><th>News Title</th><th></th></tr>';
		$output .= '</tfoot>';
		echo json_encode(array('status' => true, 'data' => $output));
		exit;
	}
	
	public function aws_insert_posts() {
		
		$news_items = $_POST['news'];
      
        $category = $_POST['category'];
		
	    //print_r($news_items);
	    
	    //die();
		
		foreach($news_items['title'] as $key => $title){
		
			$new_pva_post = array(
				'post_type'     => 'post',
				'post_title'    => $title,
				'post_status'   => 'publish',
				'post_content'   => $news_items['description'][$key],
				'post_author'   => get_current_user_id(),
                'post_category' => array($category)
			);

			// Insert the post into the database
			$post_id = wp_insert_post( $new_pva_post );
			
			ksa_upload_from_url($news_items['image'][$key], $post_id);
		}
		
		header('Content-type: application/json');
		echo json_encode(array('status' => true, 'data' => ''));
		exit;	
		
	}
	
	
	public function setScript(){
		wp_enqueue_script( 'aws_api_script', AWS_API_URL . 'assets/aws_api.js', array('jquery'), '1.2' );
		wp_localize_script( 'aws_api_script', 'awsAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
	}
	
	public function setCss(){
		echo '
			<style>
				#aws_wrap { display: flex; }
				#aws_setting_page, .aws_setting_form { width: 100%; margin:30px 0 10px 0; padding:10px; background: #fff; }
				.aws_field { width: 100%; height: 40px; }
				#aws_setting_page .danger {
					border: 2px solid red;
					padding: 10px;
					line-height: 25px;
				}
				#aws_setting_page .success {
					border: 2px solid green;
					padding: 10px;
					line-height: 25px;
				}
				#aws_setting_page { max-width: 480px; }
				.aws_setting_form { width:100%; background: #2675b9; padding-left: 20px; }
				.aws_setting_form * { color: #fff; }
				#searchForm { display: flex; }
				#searchForm .lft { width:200px; }
				#searchForm .rgt { width:calc(100%-200px); padding-left: 50px;}
				.category_list li a {
					background: #f6f6f6;
					color: #383838;
					display: block;
					margin-bottom: 0.2rem;
					padding: 0.5rem 1rem;
					text-decoration: none;
				}
				.category_list li:hover a, .category_list li.on a {
					background: #a46497;
					color: #fff;
				}
				.fields {
					margin-bottom: 15px;
				}
				#searchForm [type=submit] {
					    height: 3.2rem;
						padding: 0 1rem;
						border: none 0;
						border-radius: 0.5rem;
						font-size: 1rem;
						text-transform: uppercase;
						text-decoration: none;
						background: #a46497;
						color: #fff;
						cursor: pointer;
				}
				.search_result_import {
					padding: 30px 15px 5px 0;
				}
				#tbl_import {
					width:100%;
				}
				#tbl_import table th { text-align: left; }
				#tbl_import table td {
					padding: 10px;
					vertical-align: top;
				}
				.simple-btn { margin-left: 60px; }
			</style>
		';
	}
	
	public function aws_form_settings(){
		register_setting( 'aws-api-plugin-settings-group', 'marketplace_name' );
		register_setting( 'aws-api-plugin-settings-group', 'access_id' );
		register_setting( 'aws-api-plugin-settings-group', 'secret_access_key' );
		register_setting( 'aws-api-plugin-settings-group', 'associate_tag' );
		register_setting( 'aws-api-plugin-settings-group', 'import_category' );
	}	
	
	private function getResult( $args = array('SearchIndex'=>'All', 'Keywords'=>" ") ){
		$access_key_id 	= esc_attr( get_option('access_id') );
      
        extract($args);
		
		$term = get_category($q);
		
		$q = str_replace(' ', '+', $term->name);
      // From URL to get webpage contents.
       $url = "https://gnews.io/api/v4/search?q=$q&country=$country&topic=$topic&expand=content&token=$access_key_id";
      //$url = "https://newsdata.io/api/1/news?apikey=pub_5072296e10645e1ecf7c8f7e126158a71e7b';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      $result = curl_exec($ch);
      curl_close($ch);
      if (curl_errno($ch)) {
          return json_decode([]);
      }
      return json_decode($result);
	}
		
	public function init(){
		
		add_menu_page( 
			__('Dan News API'), 
			__('Dan News'), 
			'administrator', 
			'aws-api', 
			array($this, 'aws_api_page'), 
			AWS_API_URL.'assets/img/icon-new.png', 
			10
		);
	}
	
	function aws_api_page(){
		?>

		<div id="aws_wrap" class="wrap">
		  <div id="aws_setting_page">
			<h2> DAN NEWS API </h2>
			<form method="post" action="options.php">
			  <?php settings_fields( 'aws-api-plugin-settings-group' ); ?>
			  <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
			  <table class="form-table" width="100%">
				<!--tr>
				  <th><label for="SelectMarketplace">Select Locale : </label></th>
				  <td>
					<select id="SelectMarketplace" name="marketplace_name" class="aws_field">
						<?php foreach($this->end_points as $key=>$ep): ?>
						<option <?php echo esc_attr( get_option('marketplace_name') ) == $key ? 'selected':''; ?> value="<?php echo $key; ?>"><?php echo $ep; ?></option>
						<?php endforeach; ?>
					</select>
				  </td>
				</tr-->
				<tr>
				  <th><label for="access_id">Access Token Or API Key : </label></th>
				  <td><input type="text" class="aws_field" name="access_id" id="access_id" value="<?php echo esc_attr( get_option('access_id') ); ?>" /></td>
				</tr>
				<!--tr>
				  <th><label for="secret_access_key">Secret Access Key : </label></th>
				  <td><input type="text" class="aws_field" name="secret_access_key" id="secret_access_key" value="<?php echo esc_attr( get_option('secret_access_key') ); ?>" /></td>
				</tr>
				<tr>
				  <th><label for="associate_tag">Associate Tag : </label></th>
				  <td><input type="text" class="aws_field" name="associate_tag" id="associate_tag" value="<?php echo esc_attr( get_option('associate_tag') ); ?>" /></td>
				</tr-->
				
				<tr>
				    <th colspan="2"><label for="">Choose Categories to import</label></th>
				</tr>
				
				<?php 
				    
				    $selected_categories = get_option('import_category');
				
				    $categories = get_categories(['hide_empty'=>false]); 
				    foreach($categories as $category):    
				?>
				<tr>
				    <td colspan="2">
				        <label for="cat_<?php echo $category->term_id ?>"><input <?php echo in_array($category->term_id, $selected_categories) ? 'checked':'' ?> id="cat_<?php echo $category->term_id ?>" type="checkbox" name="import_category[]" value="<?php echo $category->term_id ?>" /> <?php echo $category->name ?></label>
				    </td>
				</tr>
				<?php endforeach; ?>
				
				<tr>
				  <td><?php  submit_button(); ?></td>
				</tr>
			  </table>
			</form>
			
			<div class="result">
			<?php
				/*
				$k				= esc_attr( get_option('marketplace_name') );
				$endpoint 		= $this->end_points[$k];	
				$access_key_id 	= esc_attr( get_option('access_id') );
				$secret_key 	= esc_attr( get_option('secret_access_key') );
				$associate_tag 	= esc_attr( get_option('associate_tag') );
				
				if(!empty($endpoint)){
					$uri = "/onca/xml";
		
					$params = array(
						"Service" => "AWSECommerceService",
						"Operation" => "ItemSearch",
						"AWSAccessKeyId" => $access_key_id,
						"AssociateTag" => $associate_tag,
						"SearchIndex" => 'All',
						"Keywords" => " ",
						"ResponseGroup" => "",
						"ItemPage" => 1
					);
					
					if (!isset($params["Timestamp"])) {
						$params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
					}
					
					// Sort the parameters by key
					ksort($params);
					
					$pairs = array();
					
					foreach ($params as $key => $value) {
						array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
					}
					
					// Generate the canonical query
					$canonical_query_string = join("&", $pairs);
					
					// Generate the string to be signed
					$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;
					
					// Generate the signature required by the Product Advertising API
					$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));
					
					// Generate the signed URL
					$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
					
					//echo "Signed URL: \"".$request_url."\"";
					
					$data = file_get_contents($request_url);
					
					$xml_obj = simplexml_load_string( $data );
				}
				*/
				$xml_obj = $this->getResult();
				if(!$xml_obj){
					//echo '<div class="danger">Incorrect API Credentials. Please check on below link <br /><a target="_blank" href="https://gnews.io/">https://gnews.io</a></div>';
				}
				else {
					//echo '<div class="success">Valid API Credentials. Please search news to import in your website</div>';
				}
			?>
			</div>
		  </div>
		  <div class="aws_setting_form">
			<h2> Search News To Import </h2>
			<form id="searchForm" method="post">
				<div class="lft">

				</div>
				<div class="rgt">
					<h2 class="search_title"><span class="dtxt">All</span> Search</h2>
					<!--div class="fields">
						<label for="keyword">Topic</label>
						<input class="aws_field" type="text" id="keyword" name="keyword" value="" />
					</div-->
                  <?php $categories = get_categories(['hide_empty'=>false]); ?>
					<div class="fields">
                    <label for="keyword">Category</label>
                    <select id="keyword" name="keyword" class="aws_field">
					 <option value="">Select Category</option>
                      <?php foreach($categories as $category) { ?>
					  <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option> 
                      <?php } ?>
                      <!--option value="entertainment"> Entertainment</option> 
                      <option value="environment"> Environment</option> 
                      <option value="food"> Food</option>  
                      <option value="health"> Health</option> 
                      <option value="politics"> Politics</option> 
                      <option value="science"> Science</option> 
                      <option value="sports"> Sports</option>
                      <option value="technology"> Technology</option>  
                      <option value="top"> Top</option>   
                      <option value="world"> World</option-->  
                    </select>
                  </div>
                  <div class="fields">
                    <label for="country">Country</label>
                    <select id="country" name="country" class="aws_field">
						<option value="">Select Country</option>
					  <option value="us" data-toggle="tooltip" title="us" selected="selected">United State</option>
					  <option value="uk" data-toggle="tooltip" title="uk">United Kingdom</option>
                    </select>
                  </div>
                    <!--
					<div class="fields">
						<label for="manufacturer">Manufacturer</label>
						<input class="aws_field" type="text" id="manufacturer" name="manufacturer" value="" />
					</div>
					<div class="fields">
						<label for="maximumprice">Maximum Price</label>
						<input class="aws_field" type="text" id="maximumprice" name="maximumprice" value="" />
					</div>
					<div class="fields">
						<label for="minimumprice">Minimum Price</label>
						<input class="aws_field" type="text" id="minimumprice" name="minimumprice" value="" />
					</div>
					<div class="fields">
						<label for="MerchantId">Merchant Id</label>
						<input class="aws_field" type="text" id="MerchantId" name="MerchantId" value="" />
					</div>
					-->
					<?php $nonce = wp_create_nonce("aws_api_nonce"); ?>
					<input type="hidden" name="_nonce" value="<?php echo $nonce; ?>" />
					<button type="submit">Search for items</button>
				</div>
			</form>
		  </div>
		</div>
<div class="search_result_import">
	<form id="importForm" method="post">
	<h2>Search Result <button class="simple-btn button button-primary" type="submit">Import</button></h2>
	<div id="tbl_import"></div>
	</form>
</div>
<?php  
	}
}

if( is_admin() ) {
	$aws_api = new AWS_API();
}

function curl_get_contents($url)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function ksa_upload_from_url( $image_url, $attach_to_post = 0, $add_to_media = true ) {
	// Add Featured Image to Post
	//$image_url        = 'http://s.wordpress.org/style/images/wp-header-logo.png'; // Define the image URL here
	$post_id		  = $attach_to_post;
	$image_name       = 'news_'.$post_id.'.png';
	$upload_dir       = wp_upload_dir(); // Set upload folder
	$image_data       = curl_get_contents($image_url); // Get image data
	//echo $image_url;
	//die($image_data);
	$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
	$filename         = basename( $unique_file_name ); // Create image file name

	// Check folder permission and define file location
	if( wp_mkdir_p( $upload_dir['path'] ) ) {
	  $file = $upload_dir['path'] . '/' . $filename;
	} else {
	  $file = $upload_dir['basedir'] . '/' . $filename;
	}

	// Create the image  file on the server
    file_put_contents( $file, $image_data );


	// Check image file type
	$wp_filetype = wp_check_filetype( $filename, null );

	// Set attachment data
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title'     => sanitize_file_name( $filename ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	// Create the attachment
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

	// Include image.php
	require_once(ABSPATH . 'wp-admin/includes/image.php');

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id, $attach_data );

	// And finally assign featured image to post
	set_post_thumbnail( $post_id, $attach_id );
	
	echo $image_name;
}

register_activation_hook(__FILE__, 'my_activation');
 
function my_activation() {
    if (! wp_next_scheduled ( 'my_minitue_event' )) {
    wp_schedule_event(time(), 'ten_seconds', 'my_minitue_event');
    }
}
 
add_action('my_mintue_event', 'do_this_minitue');
 
function do_this_minitue() {
   wp_mail( 'gauravbhardwaj.mca@gmail.com', 'Testing Gaurav Cron Event', 'Wow!!! Gaurav It works. Feels good!' );
}

register_deactivation_hook( __FILE__, 'my_deactivation' );
 
function my_deactivation() {
    wp_clear_scheduled_hook( 'my_mintue_event' );
}