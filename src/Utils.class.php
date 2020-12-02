<?php
namespace ASOTA;

class Util {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

	function __construct(){}

	/**
	 * Build Post Type Labels
	 * @param string $name The singular name of the post type
	 * @param string $plural The plural name of the post type
	 * @return array the wordpress arguments
	 */

	public static function build_type_labels($name, $plural) {

		return array(
			'name'               => $plural,
			'singular_name'      => $name,
			'add_new'            => "Add New",
			'add_new_item'       => "Add New $name",
			'edit_item'          => "Edit $name",
			'new_item'           => "New $name",
			'all_items'          => "All $plural",
			'view_item'          => "View $name",
			'search_items'       => "Search $plural",
			'not_found'          => "No " . strtolower($plural) . " found",
			'not_found_in_trash' => "No " . strtolower($plural) . " found in trash",
			'parent_item_colon'  => '',
			'menu_name'          => $plural
		);

	}

	/**
	 * Build Taxonomy Labels
	 * An easy way to build taxonomy labels. Defined once to be used everywhere.
	 * @param string $single The singular name of the taxonomy
	 * @param string|bool $plural The plural name of the taxonomy
	 * @return array The arguments to build the taxonomy
	 */

	public static function build_taxonomy_labels($single, $plural=false){

	    if(!$plural) $plural = $single . 's';

		$labels = array(
			'name'                       => ucfirst($plural),
			'singular_name'              => ucfirst($single),
			'search_items'               => 'Search ' . ucfirst($plural),
			'popular_items'              => 'Popular ' . ucfirst($plural),
			'all_items'                  => 'All ' . ucfirst($plural),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => 'Edit ' . ucfirst($single),
			'update_item'                => 'Update ' . ucfirst($single),
			'add_new_item'               => 'Add New ' . ucfirst($single),
			'new_item_name'              => 'New Writer ' . ucfirst($single),
			'separate_items_with_commas' => 'Separate ' . ucfirst($plural) . ' with commas',
			'add_or_remove_items'        => 'Add or remove ' . $plural,
			'choose_from_most_used'      => 'Choose from the most used ' . $plural,
			'not_found'                  => 'No ' . $plural . ' found',
			'menu_name'                  => ucfirst($plural),
		);

		return $labels;

	}


	/**
	 * Email
	 * Send an email with optional replacements
	 * @param string $to The To address
	 * @param string $subject The Email Subject
	 * @param string $message The Email Message
	 * @param array  $replacements An array of replacements to string replace in the email body
	 * @return null
	 */

	public static function email($to, $subject, $message, $replacements = array(), $replyto = null) {

		//replacements
		foreach ($replacements as $variable => $replacement) {
			$message = str_replace($variable, $replacement, $message);
			$subject = str_replace($variable, $replacement, $subject);
		}

		//Send from the site email
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>'
		);

		if(!empty($replyto)) $headers[] = 'Reply-To: ' . $replyto;

		//WP mail function
		wp_mail( $to, $subject, $message , $headers);

	}

	/**
	 * Redirect
	 * Redirect to another page
	 * @param int|string $path The Wordpress ID or a string path
	 * @return null
	 */

	public static function redirect($path, $qs = null) {

		if(is_numeric($path)){ $path = get_permalink($path); }
		if(!empty($qs)) $path .= $qs;
		\wp_safe_redirect( $path );
	  	exit();

	}

	/**
	 * Output JSON
	 * Convert an Array or Object to JSON and print to the screen.
	 * @param array|object $array The value to convert to JSON
	 * @return null
	 */

	public static function output_json($array) {

		header('Content-type: application/json');
		echo json_encode($array);
		exit();

	}

	/**
	 * Output CSV
	 * Convert and array into a CSV File for download
	 * @param array  $array The array to convert
	 * @param string $filename The name of the file to save as
	 * @return null
	 */

	public static function output_csv($array, $filename = 'report.csv') {

		ob_clean();
		ob_start();

		$file = fopen('php://output', 'w');

		// generate csv lines from the inner arrays
		$headings = array();
		foreach ($array[0] as $key => $line) {
			$headings[] = $key;
		}

		fputcsv($file, $headings);
		foreach($array as $row) {
		    fputcsv($file, $row);
		}

	    // rewind file
	    $output = stream_get_contents($file);
	    fclose($file);

	    // prep download
	    header("Content-type: text/x-csv");
	    header("Content-Transfer-Encoding: binary");
	    header('Content-Disposition: attachement; filename="' . $filename . '";');
	    header("Pragma: no-cache");
	    header("Expires: 0");

	    echo $output;
	    exit();

	}


	public static function errors( $error ){

		if(!$error) return;

		$class = ($error['status'] == 'bad') ? 'error' : 'success';

		echo '<p class="'.$error['status'].  ' ' . $class . '">'.$error['message']."</p>";

	}


	/**
	 * Trace
	 * @param * $val
	 * @param string $title
	 * @return null
	 */

	public static function trace($val, $title = null){

	    print "<pre>";

	    if($title) echo "<b>$title</b>\n";

	    if(is_array($val)) print_r($val);
	    elseif(is_object($val)) print var_dump($val);
	    else print $val;

	    print "</pre>";
	}

	/**
	 * The Current Full Url
	 * @return string
	 */

	public static function current_url(){

		if(!empty($_SERVER['HTTPS'])) return "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		else return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	}

	public static function salt(){

		return md5('thesaltyasota');

	}

	public static function encrypt($value){

		// Simple Ecryption
		return base64_encode(self::salt().$value);

	}

	public static function decrypt($value){
		
		// Decode
		$decoded = base64_decode($value);

		// Replace Salt
		$decoded = str_replace(self::salt(),'',$decoded);
		return $decoded;
	}

	public static function import_image_from_url($url, $post_id = null, $post_date = null){

		if(empty($url)) return;
		if(strstr($url,'?')){
			$q = explode('?',$url);
			if(!empty($q[0])) $url = $q[0];
		}

		// Include Importer
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		// Set Size
		$filename = basename($url);
		$filetype = wp_check_filetype( basename( $url ), null );

		// Save As
		$local_path = download_url($url);
		$data = file_get_contents($local_path);
		$wp_upload_dir = wp_upload_dir($post_date);

		// Check If Already Imported
		$attachment_id = \SermonSnap\Util::get_attachment_id_from_url($wp_upload_dir['url'] . '/' . $filename);
		if(!empty($attachment_id)) return $wp_upload_dir['url'] . '/' . $filename;

		// Save File to Uploads Folder
		file_put_contents($wp_upload_dir['path'].'/'.$filename, $data);

		// Load it
		$result = media_sideload_image($wp_upload_dir['url'] . '/' . $filename,$post_id,'','src');
		if($result) return $result;

		return false;

	}

	public static function import_file_from_url($url, $post_id = null, $post_date = null){

		$original = $url;
		if(empty($url)) return;
		if(strstr($url,'?')){
			$q = explode('?',$url);
			if(!empty($q[0])) $url = $q[0];
		}

		// Include Importer
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		// Set Size
		$filename = basename($url);
		$filetype = wp_check_filetype( basename( $url ), null );

		// Save As
		$local_path = download_url($url);
		$data = file_get_contents($local_path);
		$wp_upload_dir = wp_upload_dir($post_date);

		// Fix for custom file names
		$filename = uniqid() . '--' .$filename;

		// Get Extension
		$ps = explode('.',$filename);
		$ext = end($ps);

		// Remove Special Characters
		$filename = preg_replace('/[^a-zA-Z0-9_ -]/s','',$filename);
		
		// Add Extension
		$filename .= '.'.$ext;

		// Save File to Uploads Folder
		file_put_contents($wp_upload_dir['path'].'/'.$filename, $data);

		// Create Attachment
		$attachment = array(
			'guid'           => $wp_upload_dir['url'].'/'.$filename,
			'post_mime_type' => $filetype['type'],
		 	'post_title' => sanitize_file_name($filename),
		 	'post_content' => '',
		 	'post_status' => 'inherit'
		 );

		// Insert Attachment
		$attach_id = wp_insert_attachment( $attachment, $wp_upload_dir['path'].'/'.$filename );
		$attach_data = wp_generate_attachment_metadata($attach_id, $wp_upload_dir['path'].'/'.$filename);
		wp_update_attachment_metadata($attach_id, $attach_data);

		if($attach_id) return $attach_id;

		return false;

	}

	public static function update_guid($url,$post_id){

		global $wpdb;
		$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET guid = %s WHERE ID = %d",$url,$post_id));

	}

	public static function get_attachment_id_from_url($url){

		global $wpdb;
    	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));
		if(empty($attachment)) return false;
		return $attachment[0];

	}

	public static function show_errors(){
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	public static function no_timeout(){
		@ini_set('memory_limit','1024M');
        @ini_set('max_execution_time','0');
	}

	public static function load_from_cache($key){
        $data = get_option($key);
        if(empty($data)) return null;
        $now = time();
        if($now > $data['expire']) return null;
        return $data['data'];
    }

    public static function save_to_cache($key, $data, $expire = 2000){
        $cache = array();
        $cache['data'] = $data;
        $cache['expire'] = time() + $expire; 
        update_option($key,$cache);
    }

}
?>