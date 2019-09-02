<?php
/**
 * The sidebar containing the main Sidebar area.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
	$magbook_settings = magbook_get_theme_options();
	global $magbook_content_layout;
	if( $post ) {
		$layout = get_post_meta( get_queried_object_id(), 'magbook_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}

if( 'default' == $layout ) { //Settings from customizer
	if(($magbook_settings['magbook_sidebar_layout_options'] != 'nosidebar') && ($magbook_settings['magbook_sidebar_layout_options'] != 'fullwidth')){ ?>
<aside id="secondary" class="widget-area">
<?php }
}else{ // for page/ post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){ ?>
<aside id="secondary" class="widget-area">
    
  <?php }
	}?>
  <?php 
	if( 'default' == $layout ) { //Settings from customizer
		if(($magbook_settings['magbook_sidebar_layout_options'] != 'nosidebar') && ($magbook_settings['magbook_sidebar_layout_options'] != 'fullwidth')): ?>
  <?php dynamic_sidebar( 'magbook_main_sidebar' ); ?>
</aside><!-- end #secondary -->
    <style>
    .swiper-container2{
        overflow: hidden;
        height: 310px !important;
        width: 310px;

    }
    .swiper-container2 .swiper-slide img{
        height: 100%;
        width: 100%;
    }
    @media only screen  and (min-device-width: 415px)  and (max-device-width: 768px) {
        .swiper-container2{
            display: block;
            margin: auto;
        }
    }
    @media only screen  and (min-device-width: 769px)  and (max-device-width: 1024px){
         .swiper-container2{
             width: 250px;
         }
         .swiper-container2 .swiper-slide img{
             height: unset;
             width: 100%;
         }
    }
    @media only screen and (max-device-width: 414px) {
	     .swiper-container2{
	        display: block;
	        margin: auto;
	    }   
    }
    </style>
<?php endif;
	}else{ // for page/post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){
			dynamic_sidebar( 'magbook_main_sidebar' );
			echo '</aside><!-- end #secondary -->';
		}
	}