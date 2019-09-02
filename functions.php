<?php
/**
 * Display all magbook functions and definitions
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

/************************************************************************************************/
if ( ! function_exists( 'magbook_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function magbook_setup() {
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width=790;
	}

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('post-thumbnails');

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'magbook-featured-image', 700, 496, true );
	add_image_size( 'magbook-featured-blog', 820, 480, true );
	add_image_size( 'magbook-featured-slider', 1920, 1080, true );

	register_nav_menus( array(
		'top-menu' => __( 'Top Menu', 'magbook' ),
		'primary' => __( 'Main Menu', 'magbook' ),
		'side-nav-menu' => __( 'Side Menu', 'magbook' ),
		'footermenu' => __( 'Footer Menu', 'magbook' ),
		'social-link'  => __( 'Add Social Icons Only', 'magbook' ),
	) );

	/* 
	* Enable support for custom logo. 
	*
	*/ 
	add_theme_support( 'custom-logo', array(
		'flex-width' => true, 
		'flex-height' => true,
	) );

	add_theme_support( 'gutenberg', array(
			'colors' => array(
				'#0c4cba',
			),
		) );
	add_theme_support( 'align-wide' );

	//Indicate widget sidebars can use selective refresh in the Customizer. 
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Switch default core markup for comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat' ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'magbook_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_editor_style( array( 'css/editor-style.css') );

/**
 * Load WooCommerce compatibility files.
 */
	
require get_template_directory() . '/woocommerce/functions.php';


}
endif; // magbook_setup
add_action( 'after_setup_theme', 'magbook_setup' );

/***************************************************************************************/
function magbook_content_width() {
	if ( is_page_template( 'page-templates/gallery-template.php' ) || is_attachment() ) {
		global $content_width;
		$content_width = 1170;
	}
}
add_action( 'template_redirect', 'magbook_content_width' );

/***************************************************************************************/
if(!function_exists('magbook_get_theme_options')):
	function magbook_get_theme_options() {
	    return wp_parse_args(  get_option( 'magbook_theme_options', array() ), magbook_get_option_defaults_values() );
	}
endif;

/***************************************************************************************/
require get_template_directory() . '/inc/customizer/magbook-default-values.php';
require get_template_directory() . '/inc/settings/magbook-functions.php';
require get_template_directory() . '/inc/settings/magbook-common-functions.php';
require get_template_directory() . '/inc/jetpack.php';

/************************ Magbook Sidebar/ Widgets  *****************************/
require get_template_directory() . '/inc/widgets/widgets-functions/register-widgets.php';
require get_template_directory() . '/inc/widgets/widgets-functions/category-box-widget.php';
require get_template_directory() . '/inc/widgets/widgets-functions/category-box-two-layout-widget.php';
require get_template_directory() . '/inc/widgets/widgets-functions/popular-tags-comments.php';

/************************ Magbook Customizer  *****************************/
require get_template_directory() . '/inc/customizer/functions/sanitize-functions.php';
require get_template_directory() . '/inc/customizer/functions/register-panel.php';

function magbook_customize_register( $wp_customize ) {
	if(!class_exists('Magbook_Plus_Features')){
		class Magbook_Customize_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
				<a title="<?php esc_attr_e( 'Review Us', 'magbook' ); ?>" href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/magbook/' ); ?>" target="_blank" id="about_magbook">
				<?php esc_html_e( 'Review Us', 'magbook' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://themefreesia.com/theme-instruction/magbook/' ); ?>" title="<?php esc_attr_e( 'Theme Instructions', 'magbook' ); ?>" target="_blank" id="about_magbook">
				<?php esc_html_e( 'Theme Instructions', 'magbook' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://tickets.themefreesia.com/' ); ?>" title="<?php esc_attr_e( 'Support Tickets', 'magbook' ); ?>" target="_blank" id="about_magbook">
				<?php esc_html_e( 'Forum', 'magbook' ); ?>
				</a><br/>
			<?php
			}
		}
		$wp_customize->add_section('magbook_upgrade_links', array(
			'title'					=> __('Important Links', 'magbook'),
			'priority'				=> 1000,
		));
		$wp_customize->add_setting( 'magbook_upgrade_links', array(
			'default'				=> false,
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Magbook_Customize_upgrade(
			$wp_customize,
			'magbook_upgrade_links',
				array(
					'section'				=> 'magbook_upgrade_links',
					'settings'				=> 'magbook_upgrade_links',
				)
			)
		);
	}	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'magbook_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'magbook_customize_partial_blogdescription',
		) );
	}
	
	require get_template_directory() . '/inc/customizer/functions/design-options.php';
	require get_template_directory() . '/inc/customizer/functions/theme-options.php';
	require get_template_directory() . '/inc/customizer/functions/color-options.php' ;
	require get_template_directory() . '/inc/customizer/functions/featured-content-customizer.php' ;
	require get_template_directory() . '/inc/customizer/functions/frontpage-features.php' ;
}
if(!class_exists('Magbook_Plus_Features')){
	// Add Upgrade to Plus Button.
	require_once( trailingslashit( get_template_directory() ) . 'inc/upgrade-plus/class-customize.php' );
}

/* Color Styles */
require get_template_directory() . '/inc/settings/color-option-functions.php';

/** 
* Render the site title for the selective refresh partial. 
* @see magbook_customize_register() 
* @return void 
*/ 
function magbook_customize_partial_blogname() { 
bloginfo( 'name' ); 
} 

/** 
* Render the site tagline for the selective refresh partial. 
* @see magbook_customize_register() 
* @return void 
*/ 
function magbook_customize_partial_blogdescription() { 
bloginfo( 'description' ); 
}
add_action( 'customize_register', 'magbook_customize_register' );
/******************* Magbook Header Display *************************/
function magbook_header_display(){
	$magbook_settings = magbook_get_theme_options();
	$header_display = $magbook_settings['magbook_header_display'];
$magbook_header_display = $magbook_settings['magbook_header_display'];
if ($magbook_header_display == 'header_logo' || $magbook_header_display == 'header_text' || $magbook_header_display == 'show_both' || is_active_sidebar( 'magbook_header_banner' )) {

	echo '<div class="logo-bar"> <div class="wrap"> ';
		if ($header_display == 'header_logo' || $header_display == 'header_text' || $header_display == 'show_both')	{
			echo '<div id="site-branding">';
			if($header_display != 'header_text'){
				magbook_the_custom_logo();
			}
			echo '<div id="site-detail">';
				if (is_home() || is_front_page()){ ?>
				<h1 id="site-title"> <?php }else{?> <h2 id="site-title"> <?php } ?>
				<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_html(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				<?php if(is_home() || is_front_page()){ ?>
				</h1>  <!-- end .site-title -->
				<?php } else { ?> </h2> <!-- end .site-title --> <?php }

				$site_description = get_bloginfo( 'description', 'display' );
				if ($site_description){?>
					<div id="site-description"> <?php bloginfo('description');?> </div> <!-- end #site-description -->
					<?php } ?>	
		<?php echo '</div></div>'; // end #site-branding
		}
			if( is_active_sidebar( 'magbook_header_banner' )){ ?>
				<div class="advertisement-box">
					<?php dynamic_sidebar( 'magbook_header_banner' ); ?>
				</div> <!-- end .advertisement-box -->
			<?php }  ?>
		</div><!-- end .wrap -->
	</div><!-- end .logo-bar -->

<?php }
}
/************** Site Branding *************************************/
add_action('magbook_site_branding','magbook_header_display');

if ( ! function_exists( 'magbook_the_custom_logo' ) ) : 
 	/** 
 	 * Displays the optional custom logo. 
 	 * Does nothing if the custom logo is not available. 
 	 */ 
 	function magbook_the_custom_logo() { 
		if ( function_exists( 'the_custom_logo' ) ) { 
			the_custom_logo(); 
		}
 	} 
endif;

/************** Site Branding for sticky header and side menu sidebar *************************************/
add_action('magbook_new_site_branding','magbook_stite_branding_for_stickyheader_sidesidebar');

	function magbook_stite_branding_for_stickyheader_sidesidebar(){ 
	    
		$magbook_settings = magbook_get_theme_options(); ?>
		<div id="site-branding">
			<?php	
			$magbook_header_display = $magbook_settings['magbook_header_display'];
			if ($magbook_header_display == 'header_logo' || $magbook_header_display == 'show_both') {
				magbook_the_custom_logo(); 
			}

			if ($magbook_header_display == 'header_text' || $magbook_header_display == 'show_both') { ?>
			<div id="site-detail">
				<div id="site-title">
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_html(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				</div>
				 end #site-title 
				<div id="site-description"><?php bloginfo('description');?></div> <!-- end #site-description -->
			</div>
				<?php } ?>
		</div> <!-- end #site-branding -->
		<!-- custom banner--->
		
	<?php }

/************** Front Page Features *************************************/
require get_template_directory() . '/inc/front-page/front-page-features.php';

/************** Footer Menu *************************************/
function magbook_footer_menu_section(){
	if(has_nav_menu('footermenu')):
		$args = array(
			'theme_location' => 'footermenu',
			'container'      => '',
			'items_wrap'     => '<ul>%3$s</ul>',
		);
		echo '<nav id="footer-navigation">';
		wp_nav_menu($args);
		echo '</nav><!-- end #footer-navigation -->';
	endif;
}
add_action( 'magbook_footer_menu', 'magbook_footer_menu_section' );


/**************************Custom Slider 1********************************/
// add custom short code
function custom_home_page_banner() {
    global $post;
    global $wp_query;
    ?>
    <div class="swiper-container">
     <div id="slider" class="swiper-wrapper">
         <!-- <ul> -->
         <!--<figure>-->
        <?php
            $temp = $wp_query;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $post_per_page = 100; // -1 shows all posts
            $args=array(
                'post_type' => 'slideshow',
                'orderby' => 'date',
                'order' => 'ASC',
                'paged' => $paged,
                'posts_per_page' => $post_per_page
            );
            $wp_query = new WP_Query($args); 
            if( have_posts() ) : while ($wp_query->have_posts()) : $wp_query->the_post();
            $custom = get_post_custom($post->ID);
            $url = $custom["url"][0];
            $url_open = $custom["url_open"][0];
            $custom_title = "#".$post->ID;
         ?>
        <?php if ($url != "") { ?>
        <div class="swiper-slide">
            <a href="<?php echo $url; ?>"<?php if ($url_open == "on") echo " target='_blank'"; ?>><?php the_post_thumbnail('slider', array('alt' => '', 'title' => '' )); ?></a>
            </div>
        <?php } else { ?>
        <div class="swiper-slide">
            <?php the_post_thumbnail('slider', array('alt' => '', 'title' => '' )); ?>
            </div>
        <?php } ?>

        <?php endwhile; else: ?>
        <?php endif; wp_reset_query(); $wp_query = $temp ?>
        <!-- </ul> -->
        <!--</figure>-->
        
    <!-- Add Pagination -->
            <!--<div class="swiper-pagination"></div>-->
        </div>
     </div>
     
  <script>
    var swiper = new Swiper('.swiper-container', {
      pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true,
      },
      slidePerPage: 1,
      width: 700,
      speed: 400,
      autoplay: {
            delay: 5000,
        },
      loop: true,
    });
  </script>
     <style>
        .swiper-container {
          width: 100%;
          height: 100%;
        }
        .swiper-slide {
          text-align: center;
          font-size: 18px;
          background: #fff;
          /* Center slide text vertically */
          display: -webkit-box;
          display: -ms-flexbox;
          display: -webkit-flex;
          display: flex;
          -webkit-box-pack: center;
          -ms-flex-pack: center;
          -webkit-justify-content: center;
          justify-content: center;
          -webkit-box-align: center;
          -ms-flex-align: center;
          -webkit-align-items: center;
          align-items: center;
        }
    </style>
 <?php
}
add_shortcode( 'banner-custom', 'custom_home_page_banner' );


add_action('init', 'slideshow_register');

function slideshow_register() {

    $labels = array(
        'name' => _x('Top Banner', 'post type general name'),
        'singular_name' => _x('Banner Item', 'post type singular name'),
        'add_new' => _x('Add New', 'Banner item'),
        'add_new_item' => __('Add New Banner Item'),
        'edit_item' => __('Edit Banner Item'),
        'new_item' => __('New Banner Item'),
        'view_item' => __('View Banner Item'),
        'search_items' => __('Search Banner'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail'),
        'rewrite' => array('slug' => 'slideshow', 'with_front' => FALSE)
      ); 

    register_post_type( 'slideshow' , $args );
}


add_action("admin_init", "admin_init");
function admin_init(){
  add_meta_box("url-meta", "Slider Options", "url_meta", "slideshow", "side", "low");
}

function url_meta(){
  global $post;
  $custom = get_post_custom($post->ID);
  $url = $custom["url"][0];
  $url_open = $custom["url_open"][0];
  ?>
  <label>URL:</label>
  <input name="url" value="<?php echo $url; ?>" /><br />
  <input type="checkbox" name="url_open"<?php if($url_open == "on"): echo " checked"; endif ?>>URL open in new window?<br />
  <?php
}



add_action('save_post', 'save_details');
function save_details(){
  global $post;
  if( $post->post_type == "slideshow" ) {
      if(!isset($_POST["url"])):
         return $post;
      endif;
      if($_POST["url_open"] == "on") {
        $url_open_checked = "on";
      } else {
        $url_open_checked = "off";
      }
      update_post_meta($post->ID, "url", $_POST["url"]);
      update_post_meta($post->ID, "url_open", $url_open_checked);
  }
}



/************** banner 2 ****************/
// add custom short code
function custom_home_page_banner1() {
    global $post;
    global $wp_query;
    ?>
    <div class="swiper-container1">
     <div id="slider" class="swiper-wrapper">
         <!-- <ul> -->
         <!--<figure>-->
        <?php
            $temp = $wp_query;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $post_per_page = 100; // -1 shows all posts
            $args=array(
                'post_type' => 'slideshow1',
                'orderby' => 'date',
                'order' => 'ASC',
                'paged' => $paged,
                'posts_per_page' => $post_per_page
            );
            $wp_query = new WP_Query($args); 
            if( have_posts() ) : while ($wp_query->have_posts()) : $wp_query->the_post();
            $custom = get_post_custom($post->ID);
            $url = $custom["url"][0];
            $url_open = $custom["url_open"][0];
            $custom_title = "#".$post->ID;
         ?>
        <?php if ($url != "") { ?>
        <div class="swiper-slide">
            <a href="<?php echo $url; ?>"<?php if ($url_open == "on") echo " target='_blank'"; ?>><?php the_post_thumbnail('slider', array('alt' => '', 'title' => '' )); ?></a>
            </div>
        <?php } else { ?>
        <div class="swiper-slide">
            <?php the_post_thumbnail('slider', array('alt' => '', 'title' => '' )); ?>
            </div>
        <?php } ?>

        <?php endwhile; else: ?>
        <?php endif; wp_reset_query(); $wp_query = $temp ?>
        <!-- </ul> -->
        <!--</figure>-->
        
    <!-- Add Pagination -->
            <!--<div class="swiper-pagination"></div>-->
        </div>
     </div>
     
  <script>
    var swiper = new Swiper('.swiper-container1', {
      pagination: {
        el: '.swiper-pagination1',
        dynamicBullets: true,
      },
      slidesPerView: 1,
      spaceBetween: 0,
      speed: 400,
      autoplay: {
            delay: 5000,
        },
      loop: true,
    });
  </script>
     <style>
        .swiper-container1 {
          width: 100%;
          height: 100%;
        }
        .swiper-slide1 {
          text-align: center;
          font-size: 18px;
          background: #fff;
          /* Center slide text vertically */
          display: -webkit-box;
          display: -ms-flexbox;
          display: -webkit-flex;
          display: flex;
          -webkit-box-pack: center;
          -ms-flex-pack: center;
          -webkit-justify-content: center;
          justify-content: center;
          -webkit-box-align: center;
          -ms-flex-align: center;
          -webkit-align-items: center;
          align-items: center;
        }
        .swiper-container1 .swiper-slide img{
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
 <?php
}
add_shortcode( 'banner-custom1', 'custom_home_page_banner1' );

add_action('init', 'slideshow11_register1');

function slideshow11_register1() {

    $labels = array(
        'name' => _x('Middle Banner', 'post type general name'),
        'singular_name' => _x('banner Item', 'post type singular name'),
        'add_new' => _x('Add New', 'banner item'),
        'add_new_item' => __('Add New banner Item'),
        'edit_item' => __('Edit banner Item'),
        'new_item' => __('New banner Item'),
        'view_item' => __('View banner Item'),
        'search_items' => __('Search banner'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail'),
        'rewrite' => array('slug' => 'banner1', 'with_front' => FALSE)
      ); 

    register_post_type( 'slideshow1' , $args );
}

add_action("admin_init", "admin_init1");
function admin_init1(){
  add_meta_box("url-meta", "Banner Options", "url_meta1", "slideshow1", "side", "low");
}

function url_meta1(){
  global $post;
  $custom = get_post_custom($post->ID);
  $url = $custom["url"][0];
  $url_open = $custom["url_open"][0];
  ?>
  <label>URL:</label>
  <input name="url" value="<?php echo $url; ?>" /><br />
  <input type="checkbox" name="url_open"<?php if($url_open == "on"): echo " checked"; endif ?>>URL open in new window?<br />
  <?php
}

add_action('save_post', 'save_details1');
function save_details1(){
  global $post;
  if( $post->post_type == "slideshow1" ) {
      if(!isset($_POST["url"])):
         return $post;
      endif;
      if($_POST["url_open"] == "on") {
        $url_open_checked = "on";
      } else {
        $url_open_checked = "off";
      }
      update_post_meta($post->ID, "url", $_POST["url"]);
      update_post_meta($post->ID, "url_open", $url_open_checked);
  }
}



/************** banner 3 ****************/
// add custom short code
function custom_home_page_banner2() {
    global $post;
    global $wp_query;
    ?>
    <div class="swiper-container2">
     <div id="slider" class="swiper-wrapper">
         <!-- <ul> -->
         <!--<figure>-->
        <?php 
            $temp = $wp_query;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $post_per_page = 100; // -1 shows all posts
            $args=array(
                'post_type' => 'slideshow2',
                'orderby' => 'date',
                'order' => 'ASC',
                'paged' => $paged,
                'posts_per_page' => $post_per_page
            );
            $wp_query = new WP_Query($args); 
            if( have_posts() ) : while ($wp_query->have_posts()) : $wp_query->the_post();
            $custom = get_post_custom($post->ID);
            $url = $custom["url"][0];
            $url_open = $custom["url_open"][0];
            $custom_title = "#".$post->ID;
         ?>
        <?php if ($url != "") { ?>
        <div class="swiper-slide">
            <a href="<?php echo $url; ?>"<?php if ($url_open == "on") echo " target='_blank'"; ?>><?php the_post_thumbnail('slider', array('alt' => '', 'title' => '' )); ?></a>
            </div>
        <?php } else { ?>
        <div class="swiper-slide">
            <?php the_post_thumbnail('slider', array('alt' => '', 'title' => '' )); ?>
            </div>
        <?php } ?>

        <?php endwhile; else: ?>
        <?php endif; wp_reset_query(); $wp_query = $temp ?>
        <!-- </ul> -->
        <!--</figure>-->
        
    <!-- Add Pagination -->
            <!--<div class="swiper-pagination"></div>-->
        </div>
     </div>
     
  <script>
    var swiper = new Swiper('.swiper-container2', {
      pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true,
      },
      speed: 400,
      autoplay: {
            delay: 5000,
        },
      loop: true,
    });
  </script>
     <style>
        .swiper-container2 {
          width: 100%;
          height: 100%;
        }
        .swiper-slide {
          text-align: center;
          font-size: 18px;
          background: #fff;
          /* Center slide text vertically */
          display: -webkit-box;
          display: -ms-flexbox;
          display: -webkit-flex;
          display: flex;
          -webkit-box-pack: center;
          -ms-flex-pack: center;
          -webkit-justify-content: center;
          justify-content: center;
          -webkit-box-align: center;
          -ms-flex-align: center;
          -webkit-align-items: center;
          align-items: center;
        }
    </style>
 <?php
}
add_shortcode( 'banner-custom2', 'custom_home_page_banner2' );

add_action('init', 'slideshow22_register2');

function slideshow22_register2() {

    $labels = array(
        'name' => _x('Side Banner', 'post type general name'),
        'singular_name' => _x('banner Item', 'post type singular name'),
        'add_new' => _x('Add New', 'banner item'),
        'add_new_item' => __('Add New banner Item'),
        'edit_item' => __('Edit banner Item'),
        'new_item' => __('New banner Item'),
        'view_item' => __('View banner Item'),
        'search_items' => __('Search banner'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail'),
        'rewrite' => array('slug' => 'banner2', 'with_front' => FALSE)
      ); 

    register_post_type( 'slideshow2' , $args );
}

add_action("admin_init", "admin_init2");
function admin_init2(){
  add_meta_box("url-meta", "Banner Options", "url_meta2", "slideshow2", "side", "low");
}

function url_meta2(){
  global $post;
  $custom = get_post_custom($post->ID);
  $url = $custom["url"][0];
  $url_open = $custom["url_open"][0];
  ?>
  <label>URL:</label>
  <input name="url" value="<?php echo $url; ?>" /><br />
  <input type="checkbox" name="url_open"<?php if($url_open == "on"): echo " checked"; endif ?>>URL open in new window?<br />
  <?php
}

add_action('save_post', 'save_details2');
function save_details2(){
  global $post;
  if( $post->post_type == "slideshow2" ) {
      if(!isset($_POST["url"])):
         return $post;
      endif;
      if($_POST["url_open"] == "on") {
        $url_open_checked = "on";
      } else {
        $url_open_checked = "off";
      }
      update_post_meta($post->ID, "url", $_POST["url"]);
      update_post_meta($post->ID, "url_open", $url_open_checked);
  }
}
/**
 * Отключаем принудительную проверку новых версий WP, плагинов и темы в админке,
 * чтобы она не тормозила, когда долго не заходил и зашел...
 * Все проверки будут происходить незаметно через крон или при заходе на страницу: "Консоль > Обновления".
 *
 * @see https://wp-kama.ru/filecode/wp-includes/update.php
 * @author Kama (https://wp-kama.ru)
 * @version 1.0
 */
if( is_admin() ){
	// отключим проверку обновлений при любом заходе в админку...
	remove_action( 'admin_init', '_maybe_update_core' );
	remove_action( 'admin_init', '_maybe_update_plugins' );
	remove_action( 'admin_init', '_maybe_update_themes' );

	// отключим проверку обновлений при заходе на специальную страницу в админке...
	remove_action( 'load-plugins.php', 'wp_update_plugins' );
	remove_action( 'load-themes.php', 'wp_update_themes' );

	// оставим принудительную проверку при заходе на страницу обновлений...
	//remove_action( 'load-update-core.php', 'wp_update_plugins' );
	//remove_action( 'load-update-core.php', 'wp_update_themes' );

	// внутренняя страница админки "Update/Install Plugin" или "Update/Install Theme" - оставим не мешает...
	//remove_action( 'load-update.php', 'wp_update_plugins' );
	//remove_action( 'load-update.php', 'wp_update_themes' );

	// событие крона не трогаем, через него будет проверяться наличие обновлений - тут все отлично!
	//remove_action( 'wp_version_check', 'wp_version_check' );
	//remove_action( 'wp_update_plugins', 'wp_update_plugins' );
	//remove_action( 'wp_update_themes', 'wp_update_themes' );

	/**
	 * отключим проверку необходимости обновить браузер в консоли - мы всегда юзаем топовые браузеры!
	 * эта проверка происходит раз в неделю...
	 * @see https://wp-kama.ru/function/wp_check_browser_version
	 */
	add_filter( 'pre_site_transient_browser_'. md5( $_SERVER['HTTP_USER_AGENT'] ), '__return_true' );
}
/*  End custom post types */

/*BG Code For Creating a Event Calendar Custom Post Type*/
function crunchify_events_custom_post_type() {
	$labels = array(
		'name'                => __( 'Events' ),
		'singular_name'       => __( 'Event'),
		'menu_name'           => __( 'Events'),
		/*'parent_item_colon'   => __( 'Parent Event'),*/
		'all_items'           => __( 'All Events'),
		'view_item'           => __( 'View Event'),
		'add_new_item'        => __( 'Add New Event'),
		'add_new'             => __( 'Add New'),
		'edit_item'           => __( 'Edit Event'),
		'update_item'         => __( 'Update Event'),
		'search_items'        => __( 'Search Events'),
		'not_found'           => __( 'Not Found Event'),
		'not_found_in_trash'  => __( 'Event Not found in Trash')
	);
	$args = array(
		'label'               => __( 'events'),
		/*'description'         => __( 'Best Crunchify Deals'),*/
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'public'              => true,
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'has_archive'         => true,
		'can_export'          => true,
		'exclude_from_search' => false,
	    'yarpp_support'       => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post'
);
	register_post_type( 'events', $args );
}
//add_action( 'init', 'crunchify_events_custom_post_type', 0 );

 
/*BG Code For Create a custom taxonomy name it "Event Organizers" for your Cusstom post type Event Calendar*/
function crunchify_create_event_organizer_custom_taxonomy() {
  $labels = array(
    'name' => _x( 'Event Organizers', 'taxonomy general name' ),
    'singular_name' => _x( 'event-organizer', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Event organizer' ),
    'all_items' => __( 'All Organizers' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Organizer' ), 
    'update_item' => __( 'Update Organizer' ),
    'add_new_item' => __( 'Add New Organizer' ),
    'new_item_name' => __( 'New Event Organizer Name' ),
    'menu_name' => __( 'Event Organizers' ),
  ); 	
 
  register_taxonomy('event-organizer',array('events'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'event-organizer' ),
  ));
}
add_action( 'init', 'crunchify_create_event_organizer_custom_taxonomy', 0 );

/*BG Code For Create a custom taxonomy name it "Event Type" for your Cusstom post type Event Calendar*/
function crunchify_create_event_type_custom_taxonomy() {
  $labels = array(
    'name' => _x( 'Event Types', 'taxonomy general name' ),
    'singular_name' => _x( 'event-type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Event Type' ),
    'all_items' => __( 'All Event Type' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Event Type' ), 
    'update_item' => __( 'Update Event Type' ),
    'add_new_item' => __( 'Add New Event Type' ),
    'new_item_name' => __( 'New Event Type Name' ),
    'menu_name' => __( 'Event Types' ),
  ); 	
 
  register_taxonomy('event-type',array('events'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'event-type' ),
  ));
}
add_action( 'init', 'crunchify_create_event_type_custom_taxonomy', 0 );
/*Custom Post type end*/

/*BG Code for Create Shortcode of Custom Post Type Events*/

function crunchify_post_events_listing_shortcode1( $atts ) {
    ob_start();

$args = array(
   'taxonomy' => 'event-type',
   'orderby' => 'name',
   'order'   => 'ASC'
);
$cats = get_categories($args);
?>
<select class="event_typ_dropd" name="EventType" id="mySelectE">
<!-- <option value="" selected="selected" disabled>Select Events Type</option> -->
<?php foreach($cats as $cat) {?>
<option value="<?php echo $cat->term_id; ?>" <?php if($cat->term_id == 7707){ echo 'selected="selected"';}?>><?php echo $cat->name; ?></option>
<?php } ?>
</select> 

<script type="text/javascript">
$(document).ready(function(){
$('#mySelectE').on( 'change' , function(){
	var update_div = $('#update_divE');
	var newValue = $(this).val();
	//alert(newValue);
	var ajaxurl ='https://gp24.ro/wp-content/themes/magbook/eventpage.php';
	$.ajax({
	    type: 'POST',
	    url: ajaxurl, // use ajax_params.ajax_url if using in plugin
	    dataType: 'html',
	    data: {
	        newValue: newValue
	    },
	    success: function(response) {
	        console.log(response);
	        update_div.html(response);
	        //alert('Success');
	        $("#update_div1E").hide();
	        $("#update_divE ul li").addClass("page-eventsall");
	        /*$(".error-msg").hide();*/
	        
	    },
	    error: function(errorThrown){
	        console.log(errorThrown);
	        //alert('Failed');
	    }    
	  })
	})
});
</script>
<?php
    $query = new WP_Query( array(
        'post_type' => 'events',
        'taxonomy' => array( 'event-organizer', 'event-type' ),
        'posts_per_page' => -1,
        'tax_query' => array(
	    array(
		    'taxonomy' => 'event-type',
		    'field' => 'term_id',
		    'terms' => 7707
		    )
		  ),
        'meta_key'       => 'date',
    	'orderby'        => 'meta_value',
        'order' => 'ASC',
        /*'order' => 'ASC',
        'orderby' => 'title',*/
    ) );
    if ( $query->have_posts() ) { ?>
        <ul class="events-listing evnt_pgul" id="update_div1E">
            <?php while ( $query->have_posts() ) : $query->the_post(); 
            if(!empty(get_field("date"))){
        		$ori_date = explode('/', get_field("date"));
        		$split_ori_date = $ori_date[2]."".$ori_date[1]."".$ori_date[0];
        		$date = date("d M, Y", strtotime($split_ori_date));
    			$current_date = date("Y-m-d"); //2019-05-06
    			$evnt_date = date("Y-m-d", strtotime($date));
    			//echo $current_date."---".$evnt_date."<br>";
            } ?>

            <li id="post-<?php the_ID(); ?>" <?php //post_class(); ?> class="events custom_type-events tooltip page-eventsall" style="display:<?php if($current_date > $evnt_date){ echo 'none';} else{ echo 'block'; } ?>">
            	<!-- <a href="<?php the_permalink(); ?>" class="evnt_logo"><?php the_post_thumbnail( array( 70, 70 ) ); ?></a> -->
            	<div class="evnt_logo"><?php the_post_thumbnail( array( 50, 50 ) ); ?></div>
            	<div class="evnt_content_body">
            		<h4 class="evnt_title"><?php the_title(); ?></h4> 
            		<p class="evnt_loctn"><?php echo get_field("location_of_event").", ".wp_strip_all_tags( get_the_term_list( $post->ID, 'event-type', ' ', ' , ', ' ') ); ?></p>
            		<p class="evnt_org"><strong>Organized By: </strong><?php echo wp_strip_all_tags( get_the_term_list( $post->ID, 'event-organizer', ' ', ' , ', ' ') );?></p>
            	</div>
            	<div class="evnt_data">
            		<p class="evnt_time"><?php if(!empty(get_field("time"))){ echo "<i class='fa fa-clock-o' aria-hidden='true'></i> ".get_field("time");} ?></p>
            		<p class="evnt_datetm date"><?php //echo $ori_date = get_field("date");
            			if(!empty(get_field("date"))){
	            		$ori_date = explode('/', get_field("date"));

	            		$split_ori_date = $ori_date[2]."".$ori_date[1]."".$ori_date[0];
	            		
	            		$date = date("d M, Y", strtotime($split_ori_date));
            			echo "<strong>".date("d", strtotime($split_ori_date))."</strong><br>".date("F", strtotime($split_ori_date));} 
            			/*print_r(date("F j, Y", strtotime($date))."<br>");
	            		echo date(get_option('date_format'));*/ ?></p>
            	</div>
            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
        <?php }
    else {
    	echo "<div class='error-msg'>You don't have any events.!!</div>";
    }?>
        <div id="update_divE"></div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    /*}
    else {
    	echo "You don't have any events.!!";
    }*/
}
/*BG Code for Create Shortcode of Custom Post Type Events End*/

/*BG Code for Create Shortcode of Custom Post Type Events Widget*/

function crunchify_widget_events_listing_shortcode( $atts ) {
    ob_start();
$args = array(
   'taxonomy' => 'event-type',
   'orderby' => 'name',
   'order'   => 'ASC'
);
$cats = get_categories($args);
?>
<select class="event_typ_dropd" name="EventType" id="mySelect">
<!-- <option value="" selected="selected" disabled>Select Events Type</option> -->
<?php foreach($cats as $cat) {?>
<option value="<?php echo $cat->term_id; ?>" <?php if($cat->term_id == 7707){ echo 'selected="selected"';}?>><?php echo $cat->name; ?></option>
<?php } ?>
</select> 

<script type="text/javascript">
$(document).ready(function(){
$('#mySelect').on( 'change' , function(){
	var update_div = $('#update_div');
	var newValue = $(this).val();
	//alert(newValue);
	var ajaxurl ='https://gp24.ro/wp-content/themes/magbook/event.php';
	$.ajax({
	    type: 'POST',
	    url: ajaxurl, // use ajax_params.ajax_url if using in plugin
	    dataType: 'html',
	    data: {
	        //action: 'crunchify_widget_events_listing_shortcode',
	        newValue: newValue
	    },
	    success: function(response) {
	        console.log(response);
	        update_div.html(response);
	        //alert('Success');
	        $('#eventsContent').addClass('event_container');
	        $("#update_div1").hide();
	    },
	    error: function(errorThrown){
	        console.log(errorThrown);
	        //alert('Failed');
	    }    
	  })
	})
});
</script>
<?php

//echo '<script language="javascript" src="'.get_template_directory_uri().'/js/event.js"></script>';
//'<script>alert("'.$newValue.'")</script>';

    $query = new WP_Query( array(
        'post_type' => 'events',
        'taxonomy' => array( 'event-organizer', 'event-type' ),
        'posts_per_page' => 4,
        'tax_query' => array(
	    array(
		    'taxonomy' => 'event-type',
		    'field' => 'term_id',
		    'terms' => 7707
		    )
		  ),
        'meta_key'       => 'date',
    	'orderby'        => 'meta_value',
        'order' => 'ASC',
        /*'order' => 'ASC',
        'orderby' => 'title',*/
    ) );

    if ( $query->have_posts() ) { ?>
        <ul class="events-listing" id="update_div1">
            <?php while ( $query->have_posts() ) : $query->the_post();
            if(!empty(get_field("date"))){
        		$ori_date = explode('/', get_field("date"));
        		$split_ori_date = $ori_date[2]."".$ori_date[1]."".$ori_date[0];
        		$date = date("d M, Y", strtotime($split_ori_date));
    			$current_date = date("Y-m-d"); //2019-05-06
    			$evnt_date = date("Y-m-d", strtotime($date)); 
    			//echo $current_date."---".$evnt_date."<br>";
            }?>
            <li id="post-<?php the_ID(); ?>" <?php //post_class(); ?> class="events custom_type-events tooltip" style="display:<?php if($current_date > $evnt_date){ echo 'none';} else{ echo 'block'; } ?>">
            	<div class="evnt_logo"><?php the_post_thumbnail( array( 50, 50 ) ); ?></div>

            	<div class="evnt_content_body">
            		<h4 class="evnt_title"><?php the_title(); ?></h4> 
            		<p class="evnt_loctn"><?php echo get_field("location_of_event").", ".wp_strip_all_tags( get_the_term_list( $post->ID, 'event-type', ' ', ' , ', ' ') ); ?></p>
            		<p class="evnt_org"><strong>Organized By: </strong><?php echo wp_strip_all_tags( get_the_term_list( $post->ID, 'event-organizer', ' ', ' , ', ' ') );?></p>
            	</div>
            	<div class="evnt_data">
            		<p class="evnt_time"><?php if(!empty(get_field("time"))){ echo "<i class='fa fa-clock-o' aria-hidden='true'></i> ".get_field("time");} ?></p>
            		<p class="evnt_datetm date"><?php //echo $ori_date = get_field("date");
            			if(!empty(get_field("date"))){
	            		$ori_date = explode('/', get_field("date"));
	            		$split_ori_date = $ori_date[2]."".$ori_date[1]."".$ori_date[0];
	            		$date = date("d M, Y", strtotime($split_ori_date));
            			echo "<strong>".date("d", strtotime($split_ori_date))."</strong><br>".date("F", strtotime($split_ori_date));} ?></p>
            			
            	</div>
            </li>
        <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
		<div id="update_div"></div>
        <?php if($query->post_count > 3){?> <!-- Post count for View More -->
        <div class="viewmore_btn"><a href="https://gp24.ro/calendar/" class="event-results-btn">See More</a></div>
    <?php } $myvariable = ob_get_clean();
    return $myvariable;
    }
}
/*BG Code for Create Shortcode of Custom Post Type Events Widget End*/

function cptui_register_my_taxes_championship() {

	/**
	 * Taxonomy: Championships.
	 */

	$labels = array(
		"name" => __( "Championships", "twentysixteen" ),
		"singular_name" => __( "Championship", "twentysixteen" ),
	);

	$args = array(
		"label" => __( "Championships", "twentysixteen" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'championship', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "championship",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		);
	register_taxonomy( "championship", array( "points" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_championship' );


/*BG Code For Creating a Points Custom Post Type*/
function crunchify_pointss_custom_post_type() {
    $labels = array(
        'name'                => __( 'Points' ),
        'singular_name'       => __( 'Point'),
        'menu_name'           => __( 'Points'),
        /*'parent_item_colon'   => __( 'Parent Point'),*/
        'all_items'           => __( 'All Points'),
        'view_item'           => __( 'View Point'),
        'add_new_item'        => __( 'Add New Point'),
        'add_new'             => __( 'Add New'),
        'edit_item'           => __( 'Edit Point'),
        'update_item'         => __( 'Update Point'),
        'search_items'        => __( 'Search Points'),
        'not_found'           => __( 'Not Found Point'),
        'not_found_in_trash'  => __( 'Point Not found in Trash')
    );
    $args = array(
        'label'               => __( 'points'),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
        'public'              => true,
        'hierarchical'        => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'has_archive'         => true,
        'can_export'          => true,
        'exclude_from_search' => false,
        'yarpp_support'       => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post'
);
    register_post_type( 'points', $args );
}
//add_action( 'init', 'crunchify_pointss_custom_post_type', 0 );


/*BG Code for Create Shortcode of Custom Post Type Points Widget*/

function crunchify_widget_points_listing_shortcode( $atts ) {
    ob_start();
$args = array(
   'taxonomy' => 'event-type',
   'orderby' => 'name',
   'order'   => 'ASC'
);
$cats = get_categories($args);
?>
<select class="point_typ_dropd" name="PointsType" id="mySelectP">
<!-- <option value="" selected="selected" disabled>Select Events Type</option> -->
<?php foreach($cats as $cat) {?>
<option value="<?php echo $cat->term_id; ?>" <?php if($cat->term_id == 7707){ echo 'selected="selected"';}?>><?php echo $cat->name; ?></option>
<?php } ?>
</select> 

<script type="text/javascript">
$(document).ready(function(){
$('#mySelectP').on( 'change' , function(){
	var update_div = $('#update_divP');
	var newValue = $(this).val();
	//alert(newValue);
	var ajaxurl ='https://gp24.ro/wp-content/themes/magbook/points.php';
	$.ajax({
	    type: 'POST',
	    url: ajaxurl, // use ajax_params.ajax_url if using in plugin
	    dataType: 'html',
	    data: {
	        //action: 'crunchify_widget_events_listing_shortcode',
	        newValue: newValue
	    },
	    success: function(response) {
	        console.log(response);
	        update_div.html(response);
	        //alert('Success');
	        $('#eventsContent').addClass('event_container');
	        $("#update_div1P").hide();
	    },
	    error: function(errorThrown){
	        console.log(errorThrown);
	        //alert('Failed');
	    }    
	  })
	})
});
</script>
<?php
    $query = new WP_Query( array(
        'post_type' => 'points',
        /*'taxonomy' => array( 'point-organizer', 'point-type' ),*/
        'taxonomy' => 'point-type',
        'posts_per_page' => 4,
        'tax_query' => array(
	    array(
		    'taxonomy' => 'event-type',
		    'field' => 'term_id',
		    'terms' => 7707
		    )
		  ),
        'meta_key'       => 'number_of_points',
    	'orderby'        => 'meta_value',
        'order' => 'DESC',
        /*'orderby' => 'title',*/
    ) );
    if ( $query->have_posts() ) { 
    	$i = 1; ?>
        <ul class="events-listing" id="update_div1P">
            <?php while ( $query->have_posts() ) : $query->the_post(); 
            ?>
            <li id="post-<?php the_ID(); ?>" <?php //post_class(); ?> class="events custom_type-events tooltip pont_typ">
                <div class="evnt_logo"><?php the_post_thumbnail( array( 50, 50 ) ); ?></div>

                <div class="evnt_content_body">
                    <h4 class="evnt_title"><?php the_title(); ?></h4> 
                    <p class="evnt_loctn"><?php echo get_field("points_location").", ".wp_strip_all_tags( get_the_term_list( $post->ID, 'event-type', ' ', ' , ', ' ') ); ?></p>
                </div>
                <div class="evnt_data">
                    <p class="pnts_hstag"> <strong><?php echo "#".$i; ?></strong></p>
                    <p class="evnt_datetm date pnts_num"><?php if(!empty(get_field("number_of_points"))){ echo get_field("number_of_points")." pts";} ?></p>
                </div>
            </li>
        <?php $i++; endwhile;
            wp_reset_postdata(); ?>
        </ul>
        <div id="update_divP"></div>
        <?php if($query->post_count > 3){?> <!-- Post count for View More -->
        <div class="viewmore_btn"><a href="https://gp24.ro/point/" class="event-results-btn">See More</a></div>
    <?php } $myvariable = ob_get_clean();
    return $myvariable;
    }
}
/*BG Code for Create Shortcode of Custom Post Type Points Widget End*/

/*BG Code for Create Shortcode of Custom Post Type Points Page*/

function crunchify_page_points_listing_shortcode( $atts ) {
    ob_start();
$args = array(
   'taxonomy' => 'championship',
//   'orderby' => 'name',
//   'order'   => 'ASC'
);
$cats = get_categories($args);
?>
<select class="point_typ_dropd" name="PointsType" id="mySelectPp">
<!-- <option value="" selected="selected" disabled>Select Events Type</option> -->
<?php foreach($cats as $cat) {?>
<option value="<?php echo $cat->term_id; ?>" <?php if($cat->term_id == 7707){ echo 'selected="selected"';}?>><?php echo $cat->name; ?></option>
<?php } ?>
</select> 

<script type="text/javascript">
$(document).ready(function(){
$('#mySelectPp').on( 'change' , function(){
	var update_div = $('#update_divPp');
	var newValue = $(this).val();
	var ajaxurl ='https://gp24.ro/wp-content/themes/magbook/pointspage.php';
	$.ajax({
	    type: 'POST',
	    url: ajaxurl, // use ajax_params.ajax_url if using in plugin
	    dataType: 'html',
	    data: {
	        //action: 'crunchify_widget_events_listing_shortcode',
	        newValue: newValue
	    },
	    success: function(response) {
	        console.log(response);
	        update_div.html(response);
	        //alert('Success');
	        $("#update_div1Pp").hide();
	        $("#update_divPp ul li").addClass("page-eventsall");
	    },
	    error: function(errorThrown){
	        console.log(errorThrown);
	        //alert('Failed');
	    }    
	  })
	})
});
</script>
<?php
    $query = new WP_Query( array(
        'post_type' => 'points',
        'taxonomy' => 'point-type',
        'posts_per_page' => -1,
        'tax_query' => array(
	    array(
		    'taxonomy' => 'event-type',
		    'field' => 'term_id',
		    'terms' => 7707
		    )
		  ),
        'meta_key'       => 'number_of_points',
    	'orderby'        => 'meta_value',
        'order' => 'DESC',
        /*'orderby' => 'title',*/
    ) );

    if ( $query->have_posts() ) { 
    	$i = 1; ?>
        <ul class="events-listing evnt_pgul" id="update_div1Pp">
            <?php while ( $query->have_posts() ) : $query->the_post(); 
            ?>
            <li id="post-<?php the_ID(); ?>" <?php //post_class(); ?> class="events custom_type-events tooltip page-eventsall pont_typ">
                <div class="evnt_logo"><?php the_post_thumbnail( array( 50, 50 ) ); ?></div>

                <div class="evnt_content_body">
                    <h4 class="evnt_title"><?php the_title(); ?></h4> 
                    <p class="evnt_loctn"><?php echo get_field("points_location").", ".wp_strip_all_tags( get_the_term_list( $post->ID, 'event-type', ' ', ' , ', ' ') ); ?></p>
                </div>
                <div class="evnt_data">
                    <p class="pnts_hstag"> <strong><?php echo "#".$i; ?></strong></p>
                    <p class="evnt_datetm date pnts_num"><?php echo get_field("number_of_points")." pts"; ?></p>
                </div>
            </li>
        <?php $i++; endwhile;
            wp_reset_postdata(); ?>
        </ul>
		<div id="update_divPp"></div>       
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}

/*BG Code for Create Shortcode of Custom Post Type Events Page End*/


/*BG Code for Include Calendar Shortcode File*/
//include( get_stylesheet_directory() . '/event-calendar.php' );

/*BG Code for Include Calendar Shortcode File End*/

/*BG Code for Include Calendar Shortcode*/


function crunchify_post_events_calendar_shortcode1( $atts ) {
echo '<script language="javascript" src="'.get_template_directory_uri().'/js/calendar.js"></script>';
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'events',
        'taxonomy' => array( 'event-organizer', 'event-type' ),
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
    ) );

/// get current month and year and store them in $cMonth and $cYear variables
(intval($_REQUEST["month"])>0) ? $cMonth = intval($_REQUEST["month"]) : $cMonth = date("m");
(intval($_REQUEST["year"])>0) ? $cYear = intval($_REQUEST["year"]) : $cYear = date("Y");

// generate an array with all dates with events
$event_date = array();
if ( $query->have_posts() ) {
while ( $query->have_posts() ) : $query->the_post(); 
$event_date[] = get_field("date");

endwhile;

// calculate next and prev month and year used for next / prev month navigation links and store them in respective variables
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = intval($cMonth)-1;
$next_month = intval($cMonth)+1;

// if current month is December or January month navigation links have to be updated to point to next / prev years
if ($cMonth == 12 ) {
	$next_month = 1;
	$next_year = $cYear + 1;
} elseif ($cMonth == 1 ) {
	$prev_month = 12;
	$prev_year = $cYear - 1;
}

if ($prev_month<10) $prev_month = '0'.$prev_month;
if ($next_month<10) $next_month = '0'.$next_month;
?>
<div id="Calendar">
  <table width="100%">
  <tr>
      <td class="mNav"><a onclick="LoadMonth('<?php echo $prev_month; ?>', '<?php echo $prev_year; ?>')">&lt;&lt;</a></td>
      <td colspan="5" class="cMonth"><?php echo date("F, Y",strtotime($cYear."-".$cMonth."-01")); ?></td>
      <td class="mNav"><a onclick="LoadMonth('<?php echo $next_month; ?>', '<?php echo $next_year; ?>')">&gt;&gt;</a></td>
  </tr>
<tr>
	<td class="wDays">M</td>
	<td class="wDays">T</td>
	<td class="wDays">W</td>
	<td class="wDays">T</td>
	<td class="wDays">F</td>
	<td class="wDays">S</td>
	<td class="wDays">S</td>
</tr>
<?php 
$first_day_timestamp = mktime(0,0,0,$cMonth,1,$cYear); // time stamp for first day of the month used to calculate 
$maxday = date("t",$first_day_timestamp); // number of days in current month
$thismonth = getdate($first_day_timestamp); // find out which day of the week the first date of the month is
$startday = $thismonth['wday'] - 1; // 0 is for Sunday and as we want week to start on Mon we subtract 1

for ($i=0; $i<($maxday+$startday); $i++) {
	
	if (($i % 7) == 0 ) echo "<tr class='dates'>";
	
	if ($i < $startday) { echo "<td>&nbsp;</td>"; continue; };
	
	$current_day = $i - $startday + 1;

	if ($current_day<10) $current_day = '0'.$current_day;

// set css class name based on number of events for that day
$crnt_date_evnt = $cYear."-".$cMonth."-".$current_day;
//echo $events[$cYear."-".$cMonth."-".$current_day];

	if ($value === $crnt_date_evnt) {
		$css='withevent';
		//echo $css." ".$current_day;
		//$click = "onclick=\"LoadEvents('".$cYear."-".$cMonth."-".$current_day."')\"";
	} else {
		$css='noevent'; 		
		//$click = '';
		//echo $css."&nbsp;";
	}
	
	echo "<td class='".$css."'".$click.">". $current_day . "</td>";
	
	if (($i % 7) == 6 ) echo "</tr>";
}
//}
?> 
</table>
</div>

<?php wp_reset_postdata();
$myvariable = ob_get_clean();
return $myvariable;
} 
}

/*BG Code for Include Calendar Shortcode End*/


function wpse_modify_taxonomy() {
    // get the arguments of the already-registered taxonomy
    $language_args = get_taxonomy( 'language' ); // returns an object

    // make changes to the args
    // in this example there are three changes
    // again, note that it's an object
    $language_args->show_in_rest = true;

    // re-register the taxonomy
    register_taxonomy( 'language', 'post', (array) $language_args );
}
// hook it up to 11 so that it overrides the original register_taxonomy function
add_action( 'init', 'wpse_modify_taxonomy', 11 );


// add_shortcode( 'list-posts-events', 'crunchify_post_events_listing_shortcode1' );
// add_shortcode( 'events-calendar', 'crunchify_post_events_calendar_shortcode1' );
// add_shortcode( 'list-points-page', 'crunchify_page_points_listing_shortcode' );
// add_shortcode( 'list-points-widget', 'crunchify_widget_points_listing_shortcode' );
// add_shortcode( 'list-events-widget', 'crunchify_widget_events_listing_shortcode' );