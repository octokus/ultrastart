<?php
function get_timestamp(){
		$date = new DateTime();
		return (int)$date->getTimestamp();
}
function get_json($file="settings.json"){
	return json_decode(file_get_contents($file), true);
}
$linklist = get_json("linklist.json");
$q = $_GET["q"];
if($q){
		if(substr($q, 0, 8)!="https://") $q = "https://".$q;
		header("refresh:$s;url=$q");
		exit();
}
echo "<!DOCTYPE html>
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml' dir='ltr'><head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta charset='UTF-8'/>";
echo '<meta http-equiv="refresh" content="1860">';
echo "<meta name='ROBOTS' content='NOINDEX, NOFOLLOW' />";
echo '<link rel="stylesheet" type="text/css" href="s.css?reload=1" />';
echo '
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
console.log("joo");
$(window).resize(function() {
	// This will execute whenever the window is resized
	//const el = document.querySelector(".startlinks");
	var h=$(window).height(), w=$(window).width();
	console.log(w);
	if (w<=900) { 
		$(".startlinks").css("max-width",769);
		$(".searchbar").css("width",530);
	}
	if (w<=748) { 
		$(".startlinks").css("max-width",605);
		$(".searchbar").css("width",420);
	}
	if (w>900) { $(".startlinks").css("max-width",900);}
	//$(window).height(); // New height
	//$(window).width(); // New width
});
/*
//console.log(el.textContent);
//int old_max_width = el.style.max-width;
//console.log(el);
//if (el.textContent==1) {
*/
</script>';
echo '
<title>UltraSartpage</title></head><body>';
function search_form($title=true,$action="https://duckduckgo.com/",$n="Search DuckDuckGo",$sn="Search",$focus=0){
	echo "<div class='search_block'>";
	echo "<form action='$action' method='get' class='search_form' name='search_form'>";
	//echo "<input type='hidden' name='q' value='search'/>";
	echo "<table>";
	if($focus) { $foc = 'onLoad="document.f1.userid.focus()";'; }
	echo "<tr><td><input id='searchbar' type='search' name='q' ".$foc." value='' maxlength='300' placeholder='$n' class='searchbar'/></td>";
	echo "<td><input type='submit' name='search_button' value='$sn' class='search_button'/></td></tr>";
	echo "</table>";
	echo "</form>";
	echo "</div>";
}
echo "<div class='content'><div class='startlinks'>";
search_form(true,"index.php","Go to location","Go",1);
search_form();
foreach(array_keys($linklist) as $l){
	$img_file = "img/".$linklist[$l][1];
	echo "<span class='super_link_container'>";
	echo "<a href='http://".$linklist[$l][0]."' >";
	if(file_exists($img_file)){
		echo "<img title='".$l."' src='".$img_file."'/>";
	}
	else{
		echo "<img title='".$l."' src='img/dummy_s.jpg'/>";
	}
	echo "</a>";
	echo "</span>";
}
echo "</div></div>";
echo '<!-- // Begin Current Moon Phase HTML (c) MoonConnection.com // --><table class="moon_calendar" cellpadding="0" cellspacing="0" border="0" width="212"><tr><td align="center"><a href="https://www.moonconnection.com" target="mc_moon_ph"><img src="https://www.moonmodule.com/cs/dm/hn.gif" width="212" height="136" border="0" alt="" /></a></td></tr></table><!-- // end moon phase HTML // -->';
#$day = date ("Y-M-d", $a));
$show_calendar = true;
if($show_calendar){
	$calendar = get_json("calendar.json");
	function cal_num($a,$calendar,$current=false){
		$d = date ("d");
		$m = date ("m");
		$y = date ("Y");
		$day = $y."-".$m."-".$a;
		//echo "<br><br>".$day."<br><br>";
		if(in_array($day,array_keys($calendar))) {
			if(!$current) echo '<div class="calendar_number_happening" title="'.$calendar[$day].'">'.$a.'</div>';
			else echo '<div class="calendar_number_current_happening" title="'.$calendar[$day].'">'.$a.'</div>';
		}
		else{
			if(!$current) echo '<div class="calendar_number">'.$a.'</div>';
			else echo '<div class="calendar_number_current">'.$a.'</div>';
		}
	}
	$day = date ("d");
	$day_word = date ("l");
	$month = date ("m");
	$month_word = date ("M");
	$year = date ("Y");
	$maxDays = date('t');
	$currentDay = date('j');
	$first_day_of_month = date('N', strtotime($today))-1;
	$cal_pic = false;
	echo '
	<div class="calendar">';
	if($cal_pic){
		echo '
		  <div class="calendar__picture">
			<h2>'.$day.', '.$day_word.'</h2>
			<h3>'.$month_word.' '.$year.'</h3>
		  </div>';
	}
	echo ' <div class="calendar__date">';
	foreach(array("M","T","K","T","P","L","S") as $dd){
		echo '<div class="calendar__day">'.$dd.'</div>';
	}
	for($a=1;$a<$maxDays+1+$first_day_of_month;$a++){
		if($a>$first_day_of_month){
			if($a-$first_day_of_month==$currentDay) cal_num($a-$first_day_of_month,$calendar,true);
			else cal_num($a-$first_day_of_month,$calendar);
		}
		else cal_num(" ",$calendar);
	}
	echo '
	  </div>
	</div>
	';
}
echo "
<script type='text/javascript' language='JavaScript'>
document.forms['search_form'].elements['q'].focus();
</script>";
echo "</body></html>";
?>
