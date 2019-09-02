<?php
/**
 * The main template file.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
get_header(); ?>
<div class="wrap">
	<div id="primary" class="content-area">
	    <div class="slider_wrapper">
	        <?php echo do_shortcode( '[banner-custom1]' ); ?>
	    </div>
		<main id="main" class="site-main">
			<header class="page-header">
				<h2 class="page-title"><?php single_post_title();?></h2>
				<!-- .page-title -->
				<?php magbook_breadcrumb(); ?><!-- .breadcrumb -->
			</header><!-- .page-header -->
			<?php
			if( have_posts() ) {
				while(have_posts() ) {
					the_post();
					get_template_part( 'content', get_post_format() );
				}
			}
			else { ?>
			<h2 class="entry-title"> <?php esc_html_e( 'No Posts Found.', 'magbook' ); ?> </h2>
			<?php }
			get_template_part( 'pagination', 'none' ); ?>
		</main><!-- end #main -->
	</div> <!-- #primary -->
<?php
get_sidebar();
?>
</div><!-- end .wrap -->
<style>
    .swiper-container1{
        overflow: hidden;   
        height: 150px !important;
        margin-bottom: 20px;
        width: 820px;
    }
    
     @media only screen  and (min-device-width: 769px)  and (max-device-width: 1024px) {
    		     .swiper-container1{
    		        display: inline-block;
    		        width: 655px;
    		    }   
    		    .swiper-container1 .swiper-slide img{
    		        width: 655px;
    		        position: absolute;
    		        top: 0;
    		        left: 0;
    		    }
		    }
		    
		    @media only screen  and (min-device-width: 415px)  and (max-device-width: 768px) {

    		     .swiper-container1{
    		        display: inline-block;
    		        width: 700px;
                    height: 135px;
                    float: right;
    		    }   
    		    .swiper-container1 .swiper-slide img{
    		        width: 700px;
    		        position: absolute;
    		        top: 0;
    		        left: 0;
    		    }
		    }
		    
		     @media only screen and (max-device-width: 414px) {

    		     .swiper-container1{
    		        width: 340px;
    		        height: 60px !important;
    		    }   
    		    .swiper-container1 .swiper-slide img{
    		        width: 340px;
    		        position: absolute;
    		        top: 0;
    		        left: 0;
    		    }
		    }
</style>
<?php
get_footer();