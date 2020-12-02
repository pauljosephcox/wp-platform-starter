<?php
namespace WPPlatform;

class SampleBlock extends Block {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct(){
        $this->path    = plugin_dir_path(__FILE__);        
        $this->name = 'sample-block';
        $this->title = 'Sample Block';
        $this->description = 'A Sample Block';
        $this->template = $this->path.'sample-block.template.php';
        $this->category = 'platform-blocks';
        $this->icon = 'admin-comments';
        $this->keywords = array( 'testimonial', 'quote' );
    }
    
}
?>