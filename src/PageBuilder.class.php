<?php
namespace WPPlatform;

class PageBuilder {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct(){
		
		// Create Blocks
		$this->blocks['sample-block'] = new SampleBlock();

		// Patterns
		$this->patterns['main-header'] = new MainHeader();
		$this->patterns['portrait-card'] = new PortraitCard();
		$this->patterns['portrait-card-columns'] = new Columns('portrait-card-columns','Portrait Card Columns',$this->patterns['portrait-card']);

		// Register Blocks
		add_action('acf/init',array($this,'register_acf_block_types'));

		// Register Patterns
		add_action( 'init', array($this,'register_patterns') );


		

	}
	
	public function register_acf_block_types(){

		// Check function exists.
		if(!function_exists('acf_register_block_type')) return;

		// Register ACF Blocks
		foreach($this->blocks as $key=>$block) $block->register();

	}

	public function register_patterns(){

		// Remove Default Patterns
		$core_patterns = \WP_Block_Patterns_Registry::get_instance()->get_all_registered();
		foreach($core_patterns as $cp) unregister_block_pattern($cp['name']);

		// Register New Patterns
		foreach($this->patterns as $key=>$pattern) $pattern->register();

	}


}
?>