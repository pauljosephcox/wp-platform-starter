<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name: Wordpress Platform Starter 
 * Description: Functionality for driving the custom platform
 * Author: Paul Cox
 * Version: 1.0
 * Author URI: https://pauljosephcox.com
 */

// ------------------------------------
// Namespace
// ------------------------------------

namespace WPPlatform; 

// ------------------------------------
// Requirements
// ------------------------------------

require_once('src/Utils.class.php');
require_once('src/Dashboard.class.php');
require_once('src/PageBuilder.class.php');
require_once('src/blocks/Block.class.php');
require_once('src/patterns/Pattern.class.php');
require_once('src/blocks/sample-block/sample-block.class.php');
require_once('src/patterns/MainHeader.class.php');
require_once('src/patterns/Columns.class.php');
require_once('src/patterns/PortraitCard.class.php');

// ------------------------------------
// Plugin
// ------------------------------------

class WPPlatform {
    
    function __construct(){

        // Setup Plugin Defaults
		$this->path    = plugin_dir_path(__FILE__);
		$this->folder  = basename($this->path);
		$this->dir     = plugin_dir_url(__FILE__);
		$this->version = self::version();
		$this->debug = false;
        $this->name = 'WP Platform';
        $this->slug = 'wp-platform';
        $this->env = (strstr($_SERVER['HTTP_HOST'],'localhost')) ? 'dev' : 'production';

        // ------------------------------------
        // Features. Comment out to turn off.
        // ------------------------------------

        // Dashboard: Replace the Wordpress Dashboard with something Client Friendly
        $this->dashboard = new Dashboard($this->env);

        // PageBuilder: Custom Gutenburg Functionality.
        $this->pagebuilder = new PageBuilder();

        // Add your own here...


    }

    // Set Version in a way that we can access it everywhere.
    public static function version(){ return '0.0.1'; }
    
}

// ------------------------------------
// Go.
// ------------------------------------

$wpplatform = new WPPlatform();

?>