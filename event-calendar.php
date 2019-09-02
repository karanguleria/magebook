<?php
/*define( 'WPINC', 'wp-includes' );
require_once( ABSPATH . WPINC . '/load.php' );*/
define( 'SHORTINIT', true );
require( '../../../wp-load.php' );

$connection = mysqli_connect("localhost","gp24_wp","KXYLx1ecB1fjA","gp24_wp");
// Check connection
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();}

/*Calendar Code*/
/// get current month and year and store them in $cMonth and $cYear variables
(intval($_REQUEST["month"])>0) ? $cMonth = intval($_REQUEST["month"]) : $cMonth = date("m");
(intval($_REQUEST["year"])>0) ? $cYear = intval($_REQUEST["year"]) : $cYear = date("Y");

$sql = "SELECT * FROM wp_posts WHERE post_type='events' and post_status='publish'";
$sql_result = mysqli_query($connection,$sql ) or die ('request "Could not execute SQL query" '.$sql);
while ($row = mysqli_fetch_assoc($sql_result)) {
	//print_r($row['post_title']);
	/*$events[$row[""]]["title"] = $row["title"];
	$events[$row["event_date"]]["description"] = $row["description"];*/
}

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
//echo $current_day."<br>";
	if ($current_day<10) $current_day = '0'.$current_day;

//print_r($cYear."-".$cMonth."-".$current_day);

// set css class name based on number of events for that day
$crnt_date_evnt = $cYear."-".$cMonth."-".$current_day;

	//if ($events[$cYear."-".$cMonth."-".$current_day]<>'') {}
	if ($crnt_date_evnt == '2019-04-25' || $crnt_date_evnt == '2019-04-27') {
		$css='withevent';
		//echo $css." ".$current_day;
		$click = "onclick=\"LoadEvents('".$cYear."-".$cMonth."-".$current_day."')\"";
	} else {
		$css='noevent'; 		
		$click = '';
		//echo $css."&nbsp;";
	}
	
	echo "<td class='".$css."'".$click.">". $current_day . "</td>";
	
	if (($i % 7) == 6 ) echo "</tr>";
}
?> 
</table>
<?php
//echo '<script>var bustcachevar=1; var bustcacheparameter=""; var siteurl = document.location.origin; function createRequestObject(){ try	{ xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");}	catch(e) {alert("Sorry, but your browser doesnt support XMLHttpRequest"); }; return xmlhttp; }; function ajaxpage(url, containerid){ var page_request = createRequestObject(); if (bustcachevar) bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime(); page_request.open("GET", url+bustcacheparameter, true); page_request.send(null); page_request.onreadystatechange=function(){ loadpage(page_request, containerid) }} function loadpage(page_request, containerid){ if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)) { document.getElementById(containerid).innerHTML=page_request.responseText;};} function LoadMonth(month, year) { ajaxpage(siteurl+"/wp-content/themes/magbook/event-calendar.php?month="+month+"&year="+year, "Calendar"); alert(1);} function LoadEvents(date) { ajaxpage("calendar.php?date="+date, "Events"); } LoadMonth(); </script>';
?>
</div>
