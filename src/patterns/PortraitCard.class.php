<?php
namespace WPPlatform;


class PortraitCard extends Pattern {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct(){
        $this->path    = plugin_dir_path(__FILE__);        
        $this->slug = 'platform-portrait-card';
        $this->title = 'Portrait Card';
        $this->description = 'This is a tall card.';
        $this->categories = array('header');
        $this->content = '
        <!-- wp:cover {"url":"http://localhost:4444/wp-content/uploads/2020/11/sacramento-276.jpg","id":19,"className":"asota-card"} -->
        <div class="wp-block-cover has-background-dim asota-card" style="background-image:url(http://localhost:4444/wp-content/uploads/2020/11/sacramento-276.jpg)"><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"left","placeholder":"Write title…","fontSize":"large"} -->
        <p class="has-text-align-left has-large-font-size">Card Title</p>
        <!-- /wp:paragraph -->
        
        <!-- wp:paragraph -->
        <p>Card Text</p>
        <!-- /wp:paragraph -->
        
        <!-- wp:buttons -->
        <div class="wp-block-buttons"><!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link">Button</a></div>
        <!-- /wp:button --></div>
        <!-- /wp:buttons --></div></div>
        <!-- /wp:cover -->
        ';
    }

    

}
?>