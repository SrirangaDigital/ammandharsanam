<?php include("../inc/include_header.php");?>
<main class="container mt-5 maincontent">
		<div class="row justify-content-center gapAboveLarge">
			<div class="col-sm-12 col-md-8">
				<div class="extra-info-bar fixed-top">	
					<h1 class="clr1 pt-5">மலர்கள் &gt; கட்டுரைகள்</h1>
<?php include("include_secondary_nav.php");?>
				</div>		
			</div>
		</div>	
		<div class="row justify-content-center volumes gapAboveLarge">

<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['volume'])){$volume = $_GET['volume'];}else{$volume = '';}

if(!(isValidVolume($volume)))
{

	echo '<div class="col-sm-12 col-md-8">';
	echo '<p class="aFeature clr2 text-center gapAboveLarge">Invalid URL</p>';
	echo '</div>';
	echo '</div>';
	echo '</main>';
	include("include_footer.php");

	exit(1);
}

$query = "select distinct part,month,year from article where volume='$volume' order by part";
$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;



if($num_rows > 0)
{
	// $isFirst = 1;
	while($row = $result->fetch_assoc())
	{
		$part = $row['part'];
		$dpart = preg_replace("/^0/", "", $part);
		$dpart = preg_replace("/\-0/", "-", $dpart);
		//echo (($row['month'] == '01') && ($isFirst == 0)) ? '<div class="deLimiter">|</div>' : '';
		$monthdetails = getMonth($row['month']) . ", " . $row['year'];
		$monthdetails = preg_replace('/^,/', '', $monthdetails);
		$imgName = $volume . '_' . $row['part'] . '.jpg';
		$partName = ($row['part'] == '99' )? 'கட்டுரைகள்' : 'கட்டுரைகள் '. $dpart;
		$monthdetails = ($row['part'] == '99' )? 'கட்டுரைகள்' : $monthdetails;

		echo '<div class="card shadow col-1">';
		echo '<a href="toc.php?vol=' . $volume . '&amp;part=' . $row['part'] . '" title="'. $monthdetails .'"><img src="img/covers/i/' . $imgName . '" class="img-fluid" alt="issue '. $dpart .'" /></a>';
		echo '<div class="card-body">';
		echo '<a href="toc.php?vol=' . $volume . '&amp;part=' . $row['part'] . '" title="'. $monthdetails .'">' . $partName  . '<br /><span class="monthdisplay badge text-bg-secondary">' . getMonth($row['month']) . '</span><br /><span class="small badge text-bg-warning">' .  $row['year']  . '</span></a>';
		echo '</div>';
		echo '</div>';

	}
}


if($result){$result->free();}
$db->close();

?>

		</div>
	</main>

<?php include("../inc/include_footer.php");?>
