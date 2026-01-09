<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent">
		<div class="row justify-content-center gapAboveLarge">
			<div class="col-sm-12 col-md-8">
				<div class="extra-info-bar fixed-top">	
					<!-- <h1 class="clr1 pt-5">ಸಂಗ್ರಹ &gt; ಸ್ಥಿರ ಶೀರ್ಷಿಕೆಗಳು</h1> -->
					<h1 class="clr1 pt-5">மலர்கள் &gt; நிலையான தலைப்புகள்</h1>
<?php include("include_secondary_nav.php");?>
				</div>		
			</div>	
			<div class="col-sm-12 col-md-12 gapAboveSmall mb-sm-5">
				<p class="gapBelowLargeSpecial">&nbsp;</p>
			</div>
<?php

include("connect.php");
require_once("common.php");

$query = 'select * from feature where feat_name != \'\' order by feat_name';

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;


if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		echo '<div class="col-sm-12 col-md-3">';
		echo ($row['feat_name'] == '') ? '' : '<div class="author"><span class="aAuthor"><a href="feat.php?feature=' . urlencode($row['feat_name']) . '&amp;featid=' . $row['featid'] . '">' . $row['feat_name'] . '</a></div>';
		echo '</div>';	
	}
} 
else {
	echo '<p class="sml mt-5 text-center clr2">ಸ್ಥಿರ ಶೀರ್ಷಿಕೆಗಳು ಇಲ್ಲ</p>';	
}

if($result){$result->free();}
$db->close();

?>
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("../inc/include_footer.php");?>
