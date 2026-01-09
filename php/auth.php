<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent">
		<div class="row justify-content-center gapAboveLarge">


<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['authid'])){$authid = $_GET['authid'];}else{$authid = '';}
if(isset($_GET['author'])){$authorname = $_GET['author'];}else{$authorname = '';}

echo '<div class="col-sm-12 col-md-8">';
echo '<div class="extra-info-bar fixed-top">';	
// echo '<h1 class="clr1 pt-5">ಸಂಗ್ರಹ &gt; ಲೇಖಕರು &gt; ' . $authorname . '</h1>';
echo '<h1 class="clr1 pt-5"> ' . $authorname . '</h1>';
include("include_secondary_nav.php");
echo '</div>';
echo '</div>';
$authorname = entityReferenceReplace($authorname);

if(!(isValidAuthid($authid) && isValidAuthor($authorname)))
{
	echo '<div class="col-sm-12 col-md-8">';
	echo '<p class="aFeature clr2 text-center gapAboveLarge">Invalid URL</p>';
	echo '</div>';
	echo '</div>';
	echo '</main>';
	include("include_footer.php");

    exit(1);
}

$query = 'select * from article where authid like \'%' . $authid . '%\'';

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

echo '<div class="col-sm-12 col-md-8 gapAbove">';

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$query3 = 'select feat_name from feature where featid=\'' . $row['featid'] . '\'';
		$result3 = $db->query($query3); 
		$row3 = $result3->fetch_assoc();

		$dpart = preg_replace("/^0/", "", $row['part']);
		$dpart = preg_replace("/\-0/", "-", $dpart);

		$info = '';
		if($row['month'] != '')
		{
			$info = $info . getMonth($row['month']);
		}
		if($row['year'] != '')
		{
			$info = $info . ' <span style="font-size: 0.95em">' . intval($row['year']) . '</span>';
		}
		if($row['maasa'] != '')
		{
			$info = $info . ', ' . $row['maasa'] . '&nbsp;ಮಾಸ';
		}
		if($row['samvatsara'] != '')
		{
			$info = $info . ', ' . $row['samvatsara'] . '&nbsp;ಸಂವತ್ಸರ';
		}
		$info = preg_replace("/^,/", "", $info);
		$info = preg_replace("/^ /", "", $info);

		$sumne = preg_split('/-/' , $row['page']);
		$row['page'] = $sumne[0];

		if($result3){$result3->free();}
		
		echo '<div class="article">';
		echo '	<div class="gapBelowSmall">';
		echo ($row3['feat_name'] != '') ? '<span class="aFeature clr2"><a href="feat.php?feature=' . urlencode($row3['feat_name']) . '&amp;featid=' . $row['featid'] . '">' . $row3['feat_name'] . '</a></span> | ' : '';
		echo '<span class="aIssue clr5"><a href="toc.php?vol=' . $row['volume'] . '&amp;part=' . $row['part'] . '">';
		echo ($row['part'] == '99') ? 'மலர் ' . intval($row['volume']) . ', ವಿಶೇಷ ಸಂಚಿಕೆ' : '  மலர் ' . intval($row['volume']) . ',  இதழ் ' . $dpart;
		// echo  ' <span class="font_resize">(' . $info . ')</span>' .'</a></span>';
		echo '</div>';
		$part = ($row['part'] == '99') ? 'ವಿಶೇಷ ಸಂಚಿಕೆ' : $row['part'];
		echo '	<span class="aTitle"><a target="_blank" href="bookreader/templates/book.php?volume=' . $row['volume'] . '&part=' . $part . '&page=' . $row['page'] . '">' . $row['title'] . '</a></span><br />';
		echo '</div>';
	}
}

if($result){$result->free();}
$db->close();

?>
			</div> 
		</div> 
	</main> 
<?php include("../inc/include_footer.php");?>
