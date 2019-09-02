<?php
/**
 * The template for displaying the footer.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */

$magbook_settings = magbook_get_theme_options(); ?>
</div><!-- end #content -->
<!-- Footer Start ============================================= -->
<footer id="colophon" class="site-footer">
<?php
 
$footer_column = $magbook_settings['magbook_footer_column_section'];
	if( is_active_sidebar( 'magbook_footer_1' ) || is_active_sidebar( 'magbook_footer_2' ) || is_active_sidebar( 'magbook_footer_3' ) || is_active_sidebar( 'magbook_footer_4' )) { ?>
	<div class="widget-wrap" <?php if($magbook_settings['magbook_img-upload-footer-image'] !=''){?>style="background-image:url('<?php echo esc_url($magbook_settings['magbook_img-upload-footer-image']); ?>');" <?php } ?>>
		<div class="wrap">
			<div class="widget-area">
			<?php
				if($footer_column == '1' || $footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_1' ) ) :
						dynamic_sidebar( 'magbook_footer_1' );
					endif;
				echo '</div><!-- end .column'.absint($footer_column). '  -->';
				}
				if($footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_2' ) ) :
						dynamic_sidebar( 'magbook_footer_2' );
					endif;
				echo '</div><!--end .column'.absint($footer_column).'  -->';
				}
				if($footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_3' ) ) :
						dynamic_sidebar( 'magbook_footer_3' );
					endif;
				echo '</div><!--end .column'.absint($footer_column).'  -->';
				}
				if($footer_column == '4'){
				echo '<div class="column-'.absint($footer_column).'">';
					if ( is_active_sidebar( 'magbook_footer_4' ) ) :
						dynamic_sidebar( 'magbook_footer_4' );
					endif;
				echo '</div><!--end .column'.absint($footer_column).  '-->';
				}
				?>
			</div> <!-- end .widget-area -->
		</div><!-- end .wrap -->
	</div> <!-- end .widget-wrap -->
	<?php } ?>
	<div class="site-info">
		<div class="wrap">
			<?php
			if($magbook_settings['magbook_buttom_social_icons'] == 0):
				do_action('magbook_social_links');
			endif; ?>
			<div class="copyright-wrap clearfix">
				<?php 
				 do_action('magbook_footer_menu');
				 
				 if ( is_active_sidebar( 'magbook_footer_options' ) ) :
					dynamic_sidebar( 'magbook_footer_options' );
				else:
					echo '<div class="copyright">'; ?>
					<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name', 'display' ); ?></a> | 
									<?php esc_html_e('Designed by:','magbook'); ?> <a title="<?php echo esc_attr__( 'Theme Freesia', 'magbook' ); ?>" target="_blank" href="<?php echo esc_url( 'https://themefreesia.com' ); ?>"><?php esc_html_e('Theme Freesia','magbook');?></a> |
									<?php date_i18n(__('Y','magbook')) ; ?> <a title="<?php echo esc_attr__( 'WordPress', 'magbook' );?>" target="_blank" href="<?php echo esc_url( 'https://wordpress.org' );?>"><?php esc_html_e('WordPress','magbook'); ?></a>  | <?php echo '&copy; ' . esc_attr__('Copyright All right reserved ','magbook'); ?>
								</div>
				<?php endif; ?>
			</div> <!-- end .copyright-wrap -->
			<div style="clear:both;"></div>
		</div> <!-- end .wrap -->
	</div> <!-- end .site-info -->
	<?php
		$disable_scroll = $magbook_settings['magbook_scroll'];
		if($disable_scroll == 0):?>
			<a class="go-to-top">
				<span class="icon-bg"></span>
				<span class="back-to-top-text"><?php _e('Top','magbook'); ?></span>
				<i class="fa fa-angle-up back-to-top-icon"></i>
			</a>
	<?php endif; ?>
	<div class="page-overlay"></div>
</footer> <!-- end #colophon -->
</div><!-- end .site-content-contain -->
</div><!-- end #page -->

<!-- <script language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/calendar.js"></script> -->

<?php wp_footer(); ?>

<!--BG Code for slideToggle of Events -->
<div id="events">
<div id="eventsHeader">
 Race Calendar & Standings
</div>
<div id="eventsBody">
  <div id="eventsContent">

  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">Race Calendar</label>

  <input id="tab2" type="radio" name="tabs">
  <label for="tab2">Standings</label>

  <section id="content1">
      <?php echo do_shortcode('[list-events-widget]');?>
  </section>

  <section id="content2">
    <?php echo do_shortcode('[list-points-widget]');?>
    
  </section>


  	<?php //echo do_shortcode('[list-events-widget]');?>
  </div>
  <!-- <div id="eventsFooter">
	<input id="eventsText" type="text" />
    <input type="button" id="eventssend" value=">" />
  </div> -->
</div>
<div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<script>
$(document).ready(function(){
	$("#eventsHeader").click(function(){
    	$("#eventsBody").slideToggle('fast', 'swing');
    	//$("#eventsBody").toggle("slide")
    	//$("#eventsBody").animate({ width: "toggle"});
    	//$("#eventsBody").show("slide", { direction: "left" }, 1000);
    });
});
</script>
<!--BG Code for slideToggle of Events End-->

</body>
</html>