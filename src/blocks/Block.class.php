<?php
namespace WPPlatform;

class Block {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct(){
        $this->path    = plugin_dir_path(__FILE__);        
        $this->name = self::slug();
        $this->title = 'Sample Block';
        $this->description = 'A Sample Block';
        $this->template = $this->path.$this->name.'.template.php';
        $this->category = 'platform-blocks';
        $this->icon = 'admin-comments';
        $this->keywords = array( 'testimonial', 'quote' );
    }

    public static function slug(){ return 'sample-block'; }
    
    public function register(){
        acf_register_block_type(array(
            'name'              => $this->name,
            'title'             => $this->title,
            'description'       => $this->description,
            'render_template'   => $this->template,
            'category'          => $this->category,
            'icon'              => $this->icon,
            'keywords'          => $this->keywords,
        ));
    }

    public static function id($block){

        $id = self::slug().'_' . $block['id'];
        if(!empty($block['anchor'])) $id = $block['anchor'];
        return esc_attr($id);

    }

    public static function classes($block){
        $className = self::slug();
        if(!empty($block['className'])) $className .= ' ' . $block['className'];
        if(!empty($block['align'])) $className .= ' align' . $block['align'];
        return esc_attr($className);
    }
}
?>