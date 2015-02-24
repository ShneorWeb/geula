<?php

function theme_styles() {

	
	wp_enqueue_style( 'main_css', get_template_directory_uri() . '/style.css' );

}
add_action( 'wp_enqueue_scripts', 'theme_styles' );

function my_scripts() {
	
	wp_enqueue_script(
		'angularjs',
		get_stylesheet_directory_uri() . '/angular/angular.min.js'
	);

	wp_enqueue_script(
		'angularjs-route',
		get_stylesheet_directory_uri() . '/angular/angular-route.min.js'
	);
	wp_enqueue_script(
		'my-scripts',
		get_stylesheet_directory_uri() . '/js/scripts.js',
		array( 'angularjs', 'angularjs-route' )
	);

	wp_localize_script(
		'my-scripts',
		'myLocalized',
		array(
			'partials' => trailingslashit( get_template_directory_uri() ) . 'partials/'
			)
	);
}

add_action( 'wp_enqueue_scripts', 'my_scripts' );

add_theme_support ('menus');

function register_theme_menus() {

	register_nav_menus(
		array(
			'header-menu'	=> _('Header Menu'),
			

      
			)
		);

		


}
add_action( 'init', 'register_theme_menus');

function register_my_menus() {
register_nav_menus(
array(
			
			'right-menu' => _( 'Right Menu' ),

      
			)
);
}
add_action( ‘init’, ‘register_my_menus’ );

// Function for creating Widegets
function create_widget($name, $id, $description) {

	register_sidebar(array(
		'name' => __( $name ),	 
		'id' => $id, 
		'description' => __( $description ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

}

// Create widgets in the footer
create_widget("Page Sidebar", "page", "Displays in the side navigation of pages");
create_widget("Blog Sidebar", "blog", "Displays in the side navigation of blog posts and main blog page");

create_widget("Footer Area", "footer", "Displays in bottom footer");

create_widget("Front Page Left", "front-left", "Displays on the left hand side of the homepage");
create_widget("Front Page Center", "front-center", "Displays in the center of the homepage");
create_widget("Front Page Right", "front-right", "Displays on the right hand side of the homepage");



/*define('MY_CATEGORY_FIELDS', 'my_category_fields_option');
add_filter('edit_category_form', 'my_category_fields');
function my_category_fields($tag) {
	$tag_extra_fields = get_option(MY_CATEGORY_FIELDS); ?>
	<table class="form-table">
		<tr class="form-field">
			<th scope="row" valign="top"><label for="custom_cat_title">Custom Category Title</label></th>
			<td><textarea  name="custom_cat_title" id="custom_cat_title"><?php echo $tag_extra_fields[$tag->term_id]['my_description']; ?></textarea>
				<p class="description">Custom category title attribute for menus on parent pages</p></td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="custom_cat_thumb">Custom Category Thumbnail</label></th>
			<td><input name="custom_cat_thumb" type="text" id="custom_cat_thumb" size="50" aria-required="false" value="<?php echo $tag_extra_fields[$tag->term_id]['my_thumbnail']; ?>" />
				<p class="description">Upload the image and enter the filename here.</p></td>
		</tr>
	</table>
    <?php
}
add_filter('edited_terms', 'update_my_category_fields');
function update_my_category_fields($term_id) {
  if($_POST['taxonomy'] == 'category'):
    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
    $tag_extra_fields[$term_id]['my_description'] = strip_tags($_POST['custom_cat_title']);
    $tag_extra_fields[$term_id]['my_thumbnail'] = strip_tags($_POST['custom_cat_thumb']);
    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
  endif;
}
add_filter('deleted_term_taxonomy', 'remove_my_category_fields');
function remove_my_category_fields($term_id) {
  if($_POST['taxonomy'] == 'category'):
    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
    unset($tag_extra_fields[$term_id]);
    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
  endif;
}*/



?>

