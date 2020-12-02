<?php
namespace WPPlatform;

class Dashboard {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct($env){
        $this->path    = plugin_dir_path(__FILE__);
		$this->slug = 'dashboard';
		$this->title = 'Dashboard';
		$this->env = $env;
		$this->remove_admin_pages = array('plugins.php','edit.php?post_type=acf-field-group');
		
		add_filter( 'admin_title', array( $this, 'page_title' ), 10, 2 );
        add_action( 'current_screen', array( $this, 'redirect' ) );
        add_action( 'admin_menu', array($this,'menus'));
    }

    public function page_title($admin_title, $title){

		global $pagenow;
        if( 'admin.php' == $pagenow && isset( $_GET['page'] ) && $this->slug == $_GET['page'] ) $admin_title = $this->title;
        return $admin_title;

    }
    
    public function redirect($path) {

		if($path->id == 'dashboard') {
			wp_safe_redirect( 'admin.php?page='.$this->slug );
	  		exit();
	  	}

    }
    
    public function menus(){

		global $parent_file;
		global $submenu_file;
		global $menu;
		global $submenu;

		// Add & Remove Pages
		add_menu_page($this->title, $this->title, 'read', $this->slug, function(){ include($this->path.'templates/dashboard.php');});
		remove_menu_page($this->slug);

		// Set Active Menu Item
		$parent_file = 'index.php';
        $submenu_file = 'index.php';

        // Name Menu Item
        $menu[2][0] = (!empty($this->title)) ? $this->title : __('Dashboard');
		$submenu['index.php'][0][0] = (!empty($this->title)) ? $this->title : '';
		

		// Remove Defaults
		if($this->env === 'production'){
			foreach($this->remove_admin_pages as $page) remove_menu_page($page);
		}

	}
	
}
?>