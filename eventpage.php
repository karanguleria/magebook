<?php
/*define( 'WPINC', 'wp-includes' );
require_once( ABSPATH . WPINC . '/load.php' );*/
define( 'SHORTINIT', true );

require_once('../../../wp-load.php');
// echo get_bloginfo( 'name' );
?>

<ul class="events-listing">
<?php

$args = array( 'post_type' => 'events' );
$query = new WP_Query( $args );

if($query->have_posts()):
//while($query->have_posts()): $query->the_post();
?>

      <li id="post-8473" class="events custom_type-events tooltip page-eventsall" style="display:block;">
            <div class="evnt_logo"><img width="50" height="50" src="https://gp24.ro/wp-content/uploads/2019/04/F1logonew-150x150.jpg" class="attachment-50x50 size-50x50 wp-post-image" alt=""></div>
            <div class="evnt_content_body">
                  <h4 class="evnt_title">GP Spain</h4>
                  <p class="evnt_loctn">Circuit de Catalunya, Formula 1</p>
                  <p class="evnt_org"><strong>Organized By: </strong>F1 World Championship</p>
            </div>
            <div class="evnt_data">
                  <p class="evnt_time"></p>
                  <p class="evnt_datetm date"><strong>12</strong><br>May</p>
            </div>
      </li>


      <?php //endwhile; ?>
    <?php //} } } ?>
</ul>
<?php echo 'have post'; ?>
<?php else: ?>
<?php echo 'No post found!'; ?>
<?php endif; ?>