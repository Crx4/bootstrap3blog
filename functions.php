<?php
/*
 * Bootstrap 3 Blog functions and definitions
*/

/* Enqueues scripts and styles. */
function bootstrap3blog_scripts() {

	// Bootstrap core CSS.
	wp_enqueue_style( 'bootstrap-core', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.6' );

	// Theme stylesheet.
	wp_enqueue_style( 'bootstrap3blog-style', get_stylesheet_uri() );

	// IE10 viewport hack for Surface/desktop Windows 8 bug.
	wp_enqueue_style( 'bootstrap3blog-ie', get_template_directory_uri() . '/css/ie.css', array( 'css/ie10-viewport-bug-workaround.css' ), '1' );
	wp_style_add_data( 'bootstrap3blog-ie', 'conditional', 'lt IE 10' );

	// Jquery min.
	wp_enqueue_script( 'bootstrap3blog-jquery', get_template_directory_uri() . '/js/jquery.min.js', array( 'jquery' ), '1.11.3', true );
	
	// Bootstrap core JavaScript.
	wp_enqueue_script( 'bootstrap3blog-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
	
	// IE10 viewport hack for Surface/desktop Windows 8 bug.
	wp_enqueue_script( 'bootstrap3blog-ie10-script', get_template_directory_uri() . '/js/ie10-viewport-bug-workaround.js', array(), '1' );
	wp_script_add_data( 'bootstrap3blog-ie10-script', 'conditional', 'lt IE 10' );
}
add_action( 'wp_enqueue_scripts', 'bootstrap3blog_scripts' );

/* Menu walker class. */
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'main-menu', 'Main Menu' );
}
class primary_menu_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args)
	{
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$activeMenuItemClass = (in_array('current-menu-item', $item->classes)) ? ' active' : '';
		$output .= $indent;

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a class="blog-nav-item'.$activeMenuItemClass.'"'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/* Widget Areas */
function sidebar_about_widgets_init() {

	register_sidebar( array(
		'name'          => 'Home right sidebar',
		'id'            => 'home_right_1',
		'before_widget' => '<div class="sidebar-module sidebar-module-inset">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'sidebar_about_widgets_init' );
function sidebar_default_widgets_init() {

	register_sidebar( array(
		'name'          => 'Home right sidebar 2',
		'id'            => 'home_right_2',
		'before_widget' => '<div class="sidebar-module">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'sidebar_default_widgets_init' );

/* Widget */
add_action( 'widgets_init', 'my_widget_init' );
 
function my_widget_init() {
    register_widget( 'sidebar_widgets_list' );
}
class sidebar_widgets_list extends WP_Widget
{
 
    public function __construct()
    {
        $widget_details = array(
            'classname' => 'sidebar_widgets_list',
            'description' => 'Bootstrap Blog Theme archive list widget.'
        );
 
        parent::__construct( 'sidebar_widgets_list', 'Archive list Widget', $widget_details );
 
    }
 
	// widget form creation
	function form($instance) {

		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
		} else {
			 $title = '';
		}
		?>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php
	}
 
	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
 
	// display widget
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		$catTemp = get_the_category();
		
		echo $before_widget;
		echo $before_title;
		echo $title ;
		echo $after_title;
		echo '<ol class="list-unstyled">';
		
		 $args = array(
			'type'            => 'monthly',
			'limit'           => '',
			'format'          => 'html', 
			'before'          => '',
			'after'           => '',
			'show_post_count' => false,
			'echo'            => 1,
			'order'           => 'DESC',
				'post_type'     => 'post'
		);
		wp_get_archives( $args ); 
		
		echo '</ol>';
		echo $after_widget;
	}
}