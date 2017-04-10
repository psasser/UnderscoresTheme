<?php

/*
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']);

if( have_rows('template_creator') )
{
	addingTemplateStuff();
}
else
{
	get_template_part( 'template-parts/content', 'page' );	
}
*/


//get the theme ready for bootstrap
function bootstrapScripts() {
	wp_enqueue_style('bootstrapcssmin', get_bloginfo('stylesheet_directory') . '/bootstrap/css/bootstrap.min.css');
	wp_enqueue_style('bootstrapthememin', get_bloginfo('stylesheet_directory') . '/bootstrap/css/bootstrap-theme.min.css');
	wp_enqueue_style('baselinecss', get_bloginfo('stylesheet_directory') . '/css/baseline.css');
	wp_enqueue_style('sitecss', get_bloginfo('stylesheet_directory') . '/css/main.css');
	
	wp_enqueue_script('bootstrapjsmain_footer', get_bloginfo('stylesheet_directory') . '/bootstrap/js/bootstrap.min.js', '', '', true);
}
add_action( 'wp_enqueue_scripts', 'bootstrapScripts' );
//End Getting the  Theme Ready for Bootstrap


//Setting up ACF Options Page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
	acf_add_options_sub_page('All Page Content');
	acf_add_options_sub_page('Social Media');	
}
//End Setting up ACF Options Page


//Adding Favicon
function addFavicon(){
	$image = get_field('favicon', 'option');

	if( !empty($image) ): ?>

		<link rel="shortcut icon" href="<?php echo $image['url']; ?>" type="image/x-icon">

	<?php endif;
}
add_action( 'wp_head', 'addFavicon' );
//End Adding Favicon


//Wordpress Mainteanance
function my_embed_oembed_html($html, $url, $attr, $post_id) {
	$newtext = '<div class="video-container">' . $html . '</div>'; //Make it responsive
	$newtext = str_replace( '?feature=oembed', '?feature=oembed&rel=0', $newtext ); //Remove suggested links
	return $newtext;
}
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

require_once(get_template_directory().'/inc/wp_bootstrap_navwalker.php');

function replace_last_nav_item($items, $args) {
	return substr_replace($items, '', strrpos($items, $args->after), strlen($args->after));
}
add_filter('wp_nav_menu','replace_last_nav_item',100,2);

function create_post_type() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio' )
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
		'menu_position' => 5,
		'hierarchical' => true,
		)
	);
	register_taxonomy(
		'portfolio-cat',
		'portfolio',
		array(
			'label' => __( 'Property Category' ),
			'hierarchical' => true
		)
	);
}
//add_action( 'init', 'create_post_type' );
function yearshortcode( $atts ) {
	return date('Y');
}
add_shortcode( 'year', 'yearshortcode' );

add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_core', '__return_true' );
//End Wordpress Maintenance


//Reuseable code pieces
function addSocialMedia($style)
{
	echo '<ul class="socialmedia">';
	
	if( have_rows('social_media_repeater', 'option') ):
    	while ( have_rows('social_media_repeater', 'option') ) : the_row();
			if(get_sub_field('social_media_link'))
			{
				if(get_sub_field('social_media_type') == "Twitter")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialtwitter symbol" title="&#xe486;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialtwitter symbol" title="&#xe286;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialtwitter symbol" title="&#xe086;" target="_blank"></a></li>';	
					}
				}
				if(get_sub_field('social_media_type') == "Facebook")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialfacebook symbol" title="&#xe427;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialfacebook symbol" title="&#xe227;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialfacebook symbol" title="&#xe027;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "LinkedIn")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="sociallinkedin symbol" title="&#xe452;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="sociallinkedin symbol" title="&#xe252;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="sociallinkedin symbol" title="&#xe052;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Pinterest")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialpinterest symbol" title="&#xe464;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialpinterest symbol" title="&#xe264;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialpinterest symbol" title="&#xe064;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "RSS Feed")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialrss symbol" title="&#xe471;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialrss symbol" title="&#xe271;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialrss symbol" title="&#xe071;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "YouTube")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialyoutube symbol" title="&#xe499;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialyoutube symbol" title="&#xe299;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialyoutube symbol" title="&#xe099;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Google Plus")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialgoogleplus symbol" title="&#xe439;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialgoogleplus symbol" title="&#xe239;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialgoogleplus symbol" title="&#xe039;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Vimeo")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialvimeo symbol" title="&#xe489;" target="_blank"></a></li>';
			
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialvimeo symbol" title="&#xe289;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialvimeo symbol" title="&#xe089;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Email")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="mailto:'.get_sub_field('social_media_link').'" class="email symbol" title="&#xe424;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="mailto:'.get_sub_field('social_media_link').'" class="email symbol" title="&#xe224;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="mailto:'.get_sub_field('social_media_link').'" class="email symbol" title="&#xe024;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Instagram")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="instagram symbol" title="&#xe500;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="instagram symbol" title="&#xe300;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="instagram symbol" title="&#xe100;" target="_blank"></a></li>';
					}
				}
			}
			
		endwhile;
	
	endif;
	
	echo '</ul>';
}
//End resuseable code pieces


//Setting up Header
function themeHeader() {
	?>
	<div class="container">
		<div class="headertexture">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo get_home_url(); ?>">
							<?php
							$image = get_field('header_logo', 'option');

							if( !empty($image) ): ?>

								<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

							<?php endif; ?>
						</a>
					</div>
					<div class="collapse navbar-collapse" id="navbar">
						<?php
							$args = array(
								'menu' => 'primary-menu',
								'title_li' => '', 
								'menu_class' => 'nav navbar-nav navbar-right',
								'container' => false,
								'walker' => new wp_bootstrap_navwalker()
							);
							wp_nav_menu($args);
						?>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>
	<?php
}
//End Setting Up Header


//Setting Up Footer
function themeFooter(){
	?>
	<div class="container">
		<div class="footertexture">
			<div class="row">
				<div class="col-sm-4">
					Navigation
				</div>
				<div class="col-sm-4">
					Mailing List
				</div>
				<div class="col-sm-4">
					Connect
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 text-center">
					<?php
						echo get_field('footer_copyright_text', 'options');
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
//End Setting Up Footer


//Setting up Template Options
function addingTemplateStuff()
{
	if( have_rows('template_creator') ):
		 // loop through the rows of data
		while ( have_rows('template_creator') ) : the_row();
	
			if( get_row_layout() == 'slideshow' ):
			
			elseif( get_row_layout() == 'call_to_action' ) :
			
			elseif( get_row_layout() == 'countdown_area' ): 
			
			elseif( get_row_layout() == 'glyphicon_teaser_area' ):
			 
			elseif( get_row_layout() == 'large_title_area_with_text_on_the_right' ): 
			
			elseif( get_row_layout() == 'number_counter_area' ): 
			
			elseif( get_row_layout() == 'collapsible_panel_section' ): 
			
			elseif( get_row_layout() == 'large_divider_image' ): 
			
			elseif( get_row_layout() == 'simple_text_section' ): 
			
			endif;
	
		endwhile;
	
	endif;	
}
//End Setting up Template Options
?>