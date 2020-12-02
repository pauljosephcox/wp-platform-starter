<?php
namespace WPPlatform;


class Pattern {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct(){
        $this->path    = plugin_dir_path(__FILE__);        
        $this->slug = '';
        $this->title = '';
        $this->description = '';
        $this->categories = array();
        $this->content = "";
    }

    
    public function register(){
        
        register_block_pattern(
            $this->slug,
            array(
                'title'       => $this->title,
                'description' => $this->description,
                'content'     => $this->content,
                'categories'  => $this->categories,
            )
        );
    }

}
?>