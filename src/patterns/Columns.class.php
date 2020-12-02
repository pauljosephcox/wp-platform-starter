<?php
namespace WPPlatform;


class Columns extends Pattern {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct($slug, $name, $component){
        $this->path    = plugin_dir_path(__FILE__);        
        $this->slug = 'platform-columns';
        $this->title = 'Platform Columns';
        $this->description = 'This is three columns of cards.';
        $this->categories = array('header');
        $this->content = '
        <!-- wp:columns {"align":"full"} -->
        <div class="wp-block-columns alignfull">
        <!-- wp:column -->
        <div class="wp-block-column">'.$component->content.'</div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">'.$component->content.'</div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">'.$component->content.'</div>
        <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
        ';
    }

    

}
?>