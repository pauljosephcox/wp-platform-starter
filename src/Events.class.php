<?php
namespace ASOTA;

class Events {

	/**
	 * Constructor
	 * Setup the core functionality changes to wordpress
	 */

    function __construct(){

        // Register Post Type
        // Register Taxonomy
        // Register Custom Fields
        
        add_action('init', array($this, 'register'), 10, 0);
		add_action( 'pre_get_posts', array($this,'exclude_old_events') );

    }

    public function register(){

        $this->register_type();
        $this->register_taxonomy();
        
        
    }

    public function register_type(){
        $args = array(
			'labels'             => Util::build_type_labels('Event', 'Events'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'event' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_icon'			 => 'dashicons-calendar',
			'menu_position'      => 40,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

        register_post_type( 'event', $args );
    }

    public function register_taxonomy(){
        $args = array(
			'hierarchical'          => true,
			'labels'                => Util::build_taxonomy_labels('Category','Categories'),
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'event-category' ),
		);

		register_taxonomy( 'event-category', 'event', $args );
	}
	
	public function exclude_old_events( $query ) {

		if ( !is_admin() && $query->is_main_query() ) {

			if( $query->is_archive && (isset($query->query['post_type']) || isset($query->query['event-category']) ) ) {

				if( $query->query['post_type'] == 'events' || $query->query['event-category'] ) {
					$query->set('order', 'ASC');
					$query->set('meta_key', 'event_start_date');
					$query->set('orderby', 'meta_value_num');
					$query->set('meta_query',array(
						'relation' => 'OR',
						array(
							'key' => 'event_start_date',
							'compare' => '>=',
							'value' => date('Ymd'),
							'type' => 'date'
						),
						array(
							'key' => 'event_end_date',
							'compare' => '>=',
							'value' => date('Ymd'),
							'type' => 'date'
						)
					));

				}
			}

		}

	}
	
}
?>