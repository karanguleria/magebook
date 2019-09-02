<?php
/*define( 'WPINC', 'wp-includes' );
require_once( ABSPATH . WPINC . '/load.php' );*/
define( 'SHORTINIT', true );
require( '../../../wp-load.php' );
$connection = mysqli_connect("localhost","gp24_wp","KXYLx1ecB1fjA","gp24_wp");
if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
?>

<!-- <select class="event_typ_dropd" name="EventType" id="mySelect">
<option value="" selected="selected" disabled>Select Events Type</option> -->
 
<?php /*$sql = "SELECT * FROM wp_term_taxonomy WHERE taxonomy='event-type'";
$sql_result = mysqli_query($connection,$sql ) or die ('request "Could not execute SQL query" '.$sql);
while ($row = mysqli_fetch_assoc($sql_result)) {
	//print_r($row['term_id']."<br>");

$sql1 = "SELECT * FROM wp_terms WHERE term_id='".$row['term_id']."'";
$sql_result1 = mysqli_query($connection,$sql1 ) or die ('request "Could not execute SQL query" '.$sql1);
while ($row1 = mysqli_fetch_assoc($sql_result1)) {*/
	//print_r($row1['name']);
?>
<!-- <option value="<?php echo $row1['term_id']; ?>"><?php echo $row1['name']; ?></option> -->

<?php /*}
}*/ ?>
<!-- </select>  -->

<?php
$newValue = $_POST['newValue'];

$sql_pst = "SELECT * FROM `wp_posts` AS post INNER JOIN wp_term_relationships rs ON rs.object_id = post.ID INNER JOIN wp_postmeta meta_data ON post.ID = meta_data.post_id AND meta_data.meta_key='location_of_event' INNER JOIN wp_terms t ON t.term_id = rs.term_taxonomy_id 
INNER JOIN wp_terms trm ON trm.term_id = rs.term_taxonomy_id INNER JOIN wp_term_taxonomy trmtx
 WHERE `post_type` = 'events' AND `post_status` = 'publish' AND rs.term_taxonomy_id ='".$newValue."' AND trmtx.taxonomy='event-organizer' AND post.ID = rs.object_id GROUP BY post_title ORDER BY meta_value ASC LIMIT 4";

$sql_result_pst = mysqli_query($connection,$sql_pst ) or die ('request "Could not execute SQL query" '.$sql_pst);

?>
<ul class="events-listing">
<?php
    while($row_pst = mysqli_fetch_assoc($sql_result_pst)) { 

    $sql_pst1 = "SELECT * FROM `wp_term_taxonomy` AS txn INNER JOIN wp_term_relationships trs ON trs.object_id = '".$row_pst['ID']."' INNER JOIN wp_terms tr ON tr.term_id = trs.term_taxonomy_id 
    WHERE `taxonomy` = 'event-organizer' AND txn.term_id = trs.term_taxonomy_id GROUP BY name ORDER BY name ASC";

    $sql_result_pst1 = mysqli_query($connection,$sql_pst1 ) or die ('request "Could not execute SQL query" '.$sql_pst1);
    while($row_pst1 = mysqli_fetch_assoc($sql_result_pst1)) {

    $sql_pst2 = "SELECT p.guid FROM wp_postmeta AS pm INNER JOIN wp_posts AS p ON pm.meta_value = p.ID WHERE pm.post_id ='".$row_pst['ID']."' AND pm.meta_key = '_thumbnail_id'";

    $sql_result_pst2 = mysqli_query($connection,$sql_pst2 );
    while($row_pst2 = mysqli_fetch_array($sql_result_pst2)) {

    $events = array();
    $sql_postmeta = "SELECT wp_posts.ID,wp_postmeta.meta_key,wp_postmeta.meta_value
    FROM wp_posts INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
    WHERE (wp_postmeta.meta_key = 'location_of_event' OR wp_postmeta.meta_key = 'date' OR wp_postmeta.meta_key = 'time') AND wp_postmeta.post_id='".$row_pst['ID']."' GROUP BY wp_postmeta.meta_key ORDER BY wp_posts.ID ASC";
        $sql_result_postmeta = mysqli_query($connection,$sql_postmeta ) or die ('request "Could not execute SQL query" '.$sql_postmeta);    

    while ($row_postmeta = mysqli_fetch_assoc($sql_result_postmeta)) {

        if($row_postmeta['meta_key']=='date'){
            $events['date'] = $row_postmeta['meta_value'];
            /*$date = date("d", strtotime($events['date']));
            $month = date("M", strtotime($events['date']));*/
        }
        if($row_postmeta['meta_key']=='location_of_event'){
            $events['location'] = $row_postmeta['meta_value'];
        }
        if($row_postmeta['meta_key']=='time'){
            $events['time'] = $row_postmeta['meta_value'];
        }
    }
    //print_r($events);
    if(!empty($events['date'])){
        $current_date = date("Y-m-d");
        $evnt_date = date("Y-m-d", strtotime($events['date']));
        //echo $evnt_date;
    }
?>
    <li id="post-<?php echo $row_pst['ID']; ?>" <?php //post_class(); ?> class="events custom_type-events tooltip" style="display:<?php if($current_date > $evnt_date){ echo 'none';} else{ echo 'block'; } ?>">
    	<div class="evnt_logo"><img src="<?php echo $row_pst2['guid']; ?>" class="attachment-50x50 size-50x50 wp-post-image" alt="" width="50" height="50"></div>

    	<div class="evnt_content_body">
    		<h4 class="evnt_title"><?php echo $row_pst['post_title']; ?></h4> 
    		<p class="evnt_loctn"><?php echo $events['location'].", ".$row_pst['name']; ?></p>
    		<p class="evnt_org"><strong>Organized By: </strong><?php echo $row_pst1['name']; ?></p>
    	</div>
    	<div class="evnt_data">
    		<p class="evnt_time"><?php if(!empty($events['time'])){ echo "<i class='fa fa-clock-o' aria-hidden='true'></i> ".date("g:i a", strtotime($events['time'])); } ?></p>
            <p class="evnt_datetm date"><?php if(!empty($events['date'])){ echo "<strong>".date("d", strtotime($events['date']))."</strong><br>".date("F", strtotime($events['date']));} ?> </p>
    			
    	</div>
    </li>
    <?php } } }?>
</ul>

