<?php
/*define( 'WPINC', 'wp-includes' );
require_once( ABSPATH . WPINC . '/load.php' );*/
define( 'SHORTINIT', true );
require( '../../../wp-load.php' );
$connection = mysqli_connect("localhost","gp24_wp","KXYLx1ecB1fjA","gp24_wp");
if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

$newValue = $_POST['newValue'];

//$sql_pst = "SELECT * FROM `wp_posts` AS post INNER JOIN wp_term_relationships rs ON rs.object_id = post.ID INNER JOIN wp_terms t ON t.term_id = rs.term_taxonomy_id INNER JOIN wp_terms trm ON trm.term_id = rs.term_taxonomy_id WHERE `post_type` = 'points' AND `post_status` = 'publish' AND rs.term_taxonomy_id ='".$newValue."' AND post.ID = rs.object_id GROUP BY post_title ORDER BY post_title ASC";

$sql_pst = "SELECT post.ID,post.post_title,post.post_status,post.post_type,meta_data.post_id,meta_data.meta_key, MAX(meta_data.meta_value),rs.object_id,rs.term_taxonomy_id,t.term_id,t.name,trm.term_id FROM `wp_posts` AS post INNER JOIN wp_term_relationships rs ON rs.object_id = post.ID INNER JOIN wp_postmeta meta_data ON post.ID = meta_data.post_id AND meta_data.meta_key='number_of_points' INNER JOIN wp_terms t ON t.term_id = rs.term_taxonomy_id 
INNER JOIN wp_terms trm ON trm.term_id = rs.term_taxonomy_id
 WHERE `post_type` = 'points' AND `post_status` = 'publish' AND rs.term_taxonomy_id ='".$newValue."' AND post.ID = rs.object_id GROUP BY post_title ORDER BY meta_value DESC";

$sql_result_pst = mysqli_query($connection,$sql_pst ) or die ('request "Could not execute SQL query" '.$sql_pst);

?>
<ul class="events-listing">
<?php  $i = 1;
    while($row_pst = mysqli_fetch_assoc($sql_result_pst)) { 

    $sql_pst2 = "SELECT p.guid FROM wp_postmeta AS pm INNER JOIN wp_posts AS p ON pm.meta_value = p.ID WHERE pm.post_id ='".$row_pst['ID']."' AND pm.meta_key = '_thumbnail_id'";

    $sql_result_pst2 = mysqli_query($connection,$sql_pst2 );
    while($row_pst2 = mysqli_fetch_array($sql_result_pst2)) {

    $events = array();
    $sql_postmeta = "SELECT wp_posts.ID,wp_postmeta.meta_key,wp_postmeta.meta_value
    FROM wp_posts INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
    WHERE (wp_postmeta.meta_key = 'points_location' OR wp_postmeta.meta_key = 'number_of_points') AND wp_postmeta.post_id='".$row_pst['ID']."' GROUP BY wp_postmeta.meta_key ORDER BY wp_posts.ID ASC";
        $sql_result_postmeta = mysqli_query($connection,$sql_postmeta ) or die ('request "Could not execute SQL query" '.$sql_postmeta);    

    while ($row_postmeta = mysqli_fetch_assoc($sql_result_postmeta)) {

        if($row_postmeta['meta_key']=='number_of_points'){
            $events['points_num'] = $row_postmeta['meta_value'];
        }
        if($row_postmeta['meta_key']=='points_location'){
            $events['plocation'] = $row_postmeta['meta_value'];
        }
        
    }
    //print_r($events);
?>
    <li id="post-<?php echo $row_pst['ID']; ?>" <?php //post_class(); ?> class="events custom_type-events tooltip pont_typ">
        <div class="evnt_logo"><img src="<?php echo $row_pst2['guid']; ?>" class="attachment-50x50 size-50x50 wp-post-image" alt="" width="50" height="50"></div>

        <div class="evnt_content_body">
            <h4 class="evnt_title"><?php echo $row_pst['post_title']; ?></h4> 
            <p class="evnt_loctn"><?php echo $events['plocation'].", ".$row_pst['name']; ?></p>
            <!-- <p class="evnt_org"><strong>Organize By: </strong><?php //echo wp_strip_all_tags( get_the_term_list( $post->ID, 'event-organizer', ' ', ' , ', ' ') );
            //the_terms( $post->ID, 'event-organizer' ); ?></p> -->
        </div>
        <div class="evnt_data">
            <p class="pnts_hstag"> <strong><?php echo "#".$i; ?></strong></p>
            <p class="evnt_datetm date pnts_num"><?php if(!empty($events['points_num'])){ echo $events['points_num']." pts";} ?></p>   
        </div>
    </li>
    <?php $i++; } } ?>
</ul>

