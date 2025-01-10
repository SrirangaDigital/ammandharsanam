<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent">
		<div class="row justify-content-center gapAboveLarge">

<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['feature'])){$feat_name = $_GET['feature'];}else{$feat_name = '';}
if(isset($_GET['featid'])){$featid = $_GET['featid'];}else{$featid = '';}

echo '<div class="col-sm-12 col-md-8">';
echo '<div class="extra-info-bar fixed-top">';	
echo '<h1 class="clr1 pt-5">Archive &gt; Features &gt; ' . $feat_name . '</h1>';
include("include_secondary_nav.php");
echo '</div>';
echo '</div>';

$feat_name = entityReferenceReplace($feat_name);

if(!(isValidFeature($feat_name) && isValidFeatid($featid)))
{
	echo '<div class="col-sm-12 col-md-8">';
	echo '<p class="aFeature clr2 text-center gapAboveLarge">Invalid URL</p>';
	echo '</div>';
	echo '</div>';
	echo '</main>';
	include("include_footer.php");

    exit(1);
}

$query = 'select * from article where featid=\'' . $featid . '\' order by volume, part, page';

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

echo '<div class="col-sm-12 col-md-8 gapAbove">';

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$dpart = preg_replace("/^0/", "", $row['part']);
		$dpart = preg_replace("/\-0/", "-", $dpart);
		
		echo '<div class="article">';
		echo '<div class="gapBelowSmall">';
		echo '<span class="aIssue clr5"><a href="toc.php?vol=' . $row['volume'] . '&amp;part=' . $row['part'] . '">';
		echo ($row['part'] == '99') ? '(Volume ' . intval($row['volume']) . ', Special Issue ' : getMonth($row['month']) . ' ' . $row['year'] . '  (Volume ' . intval($row['volume']) . ', Issue ' . $dpart;
		echo ')</a></span>';
		echo '</div>';
		$part = ($row['part'] == '99') ? 'SpecialIssue' : $row['part'];
		echo '	<span class="aTitle"><a target="_blank" href="bookreader/templates/book.php?volume=' . $row['volume'] . '&part=' . $part . '&page=' . $row['page'] . '">' . $row['title'] . '</a></span><br />';
		if($row['authid'] != 0) {

			echo '	<span class="aAuthor itl">by ';
			$authids = preg_split('/;/',$row['authid']);
			$authornames = preg_split('/;/',$row['authorname']);
			$a=0;
			foreach ($authids as $aid) {

				echo '<a href="auth.php?authid=' . $aid . '&amp;author=' . urlencode($authornames[$a]) . '">' . $authornames[$a] . '</a> ';
				$a++;
			}
			echo '</span><br/>';
		}
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
