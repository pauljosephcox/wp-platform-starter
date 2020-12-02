<?php
namespace WPPlatform;


class MainHeader extends Pattern {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct(){
        $this->path    = plugin_dir_path(__FILE__);        
        $this->slug = 'platform-main-header';
        $this->title = 'Main Header';
        $this->description = 'This is the main header to use at the top of the site.';
        $this->categories = array('header');
        $this->content = '
        <!-- wp:cover {"url":"http://localhost:4444/wp-content/uploads/2020/11/sacramento-276.jpg","id":19,"focalPoint":{"x":"0.38","y":"0.26"},"align":"wide"} -->
        <div class="wp-block-cover alignwide has-background-dim" style="background-image:url(http://localhost:4444/wp-content/uploads/2020/11/sacramento-276.jpg);background-position:38% 26%"><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"left","placeholder":"Write title…","fontSize":"huge"} -->
        <p class="has-text-align-left has-large-font-size">Cover Title</p>
        <!-- /wp:paragraph -->

        <!-- wp:paragraph {"align":"left"} -->
        <p class="has-text-align-left">Cover text</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"align":"left"} -->
        <div class="wp-block-buttons alignleft"><!-- wp:button {"className":"is-style-fill"} -->
        <div class="wp-block-button is-style-fill"><a class="wp-block-button__link">Cover Button</a></div>
        <!-- /wp:button --></div>
        <!-- /wp:buttons --></div></div>
        <!-- /wp:cover -->
        ';
    }    

}
?>