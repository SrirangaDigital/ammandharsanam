<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent" data-bs-theme="dark">
		<div class="row justify-content-center gapAboveLarge">
			<div class="col-sm-12 col-md-8">
				<div class="extra-info-bar fixed-top">	
					<h1 class="clr1 pt-5">Archive &gt; Titles</h1>
					<div class="alphabet mt-2">
						<span class="letter"><a href="articles.php?letter=A">A</a></span>
						<span class="letter"><a href="articles.php?letter=B">B</a></span>
						<span class="letter"><a href="articles.php?letter=C">C</a></span>
						<span class="letter"><a href="articles.php?letter=D">D</a></span>
						<span class="letter"><a href="articles.php?letter=E">E</a></span>
						<span class="letter"><a href="articles.php?letter=F">F</a></span>
						<span class="letter"><a href="articles.php?letter=G">G</a></span>
						<span class="letter"><a href="articles.php?letter=H">H</a></span>
						<span class="letter"><a href="articles.php?letter=I">I</a></span>
						<span class="letter"><a href="articles.php?letter=J">J</a></span>
						<span class="letter"><a href="articles.php?letter=K">K</a></span>
						<span class="letter"><a href="articles.php?letter=L">L</a></span>
						<span class="letter"><a href="articles.php?letter=M">M</a></span>
						<span class="letter"><a href="articles.php?letter=N">N</a></span>
						<span class="letter"><a href="articles.php?letter=O">O</a></span>
						<span class="letter"><a href="articles.php?letter=P">P</a></span>
						<span class="letter"><a href="articles.php?letter=Q">Q</a></span>
						<span class="letter"><a href="articles.php?letter=R">R</a></span>
						<span class="letter"><a href="articles.php?letter=S">S</a></span>
						<span class="letter"><a href="articles.php?letter=T">T</a></span>
						<span class="letter"><a href="articles.php?letter=U">U</a></span>
						<span class="letter"><a href="articles.php?letter=V">V</a></span>
						<span class="letter"><a href="articles.php?letter=W">W</a></span>
						<span class="letter"><a href="articles.php?letter=X">X</a></span>
						<span class="letter"><a href="articles.php?letter=Y">Y</a></span>
						<span class="letter"><a href="articles.php?letter=Z">Z</a></span>
						<span class="letter"><a href="articles.php?letter=Special">#</a></span>
					</div>
<?php include("include_secondary_nav.php");?>
				</div>
			</div>
			<div class="col-sm-12 col-md-8 gapAboveLarge">		
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['letter']))
{
	$letter=$_GET['letter'];
	
	if(!(isValidLetter($letter)))
	{
		echo '<p class="aFeature clr2 mt-5 text-center">Invalid URL</p>';
		echo '</div>';
		echo '</div>';
		echo '</main>';
		include("include_footer.php");

        exit(1);
	}
	
	($letter == '') ? $letter = 'A' : $letter = $letter;
}
else
{
	$letter = 'A';
}
if($letter == 'Special')
{
	$query = "select * from article where title not regexp '^[a-z]|^\'[a-z]|^\"[a-z]|^<|^\"<' order by title";
}
else
{
	$query = "select * from article where title like '$letter%' union select * from article where title like '\"$letter%' union select * from article where title like '\'$letter%' order by TRIM(BOTH '\'' FROM TRIM(BOTH '\"' FROM title))";
}

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$query3 = 'select feat_name from feature where featid=\'' . $row['featid'] . '\'';
		$result3 = $db->query($query3); 
		$row3 = $result3->fetch_assoc();
		
		$dpart = preg_replace("/^0/", "", $row['part']);
		$dpart = preg_replace("/\-0/", "-", $dpart);
		
		if($result3){$result3->free();}

		echo '<div class="article">';
		echo '	<div class="gapBelowSmall">';
		echo ($row3['feat_name'] != '') ? '<span class="aFeature clr2"><a href="feat.php?feature=' . urlencode($row3['feat_name']) . '&amp;featid=' . $row['featid'] . '">' . $row3['feat_name'] . '</a></span> | ' : '';
		echo '<span class="aIssue clr5"><a href="toc.php?vol=' . $row['volume'] . '&amp;part=' . $row['part'] . '">';
		echo ($row['part'] == '99') ? '(Volume ' . intval($row['volume']) . ', Special Issue' : getMonth($row['month']) . ' ' . $row['year'] . '  (Volume ' . intval($row['volume']) . ', Issue ' . $dpart;
		echo ')</a></span>';
		echo '</div>';
		$part = ($row['part'] == '99') ? 'SpecialIssue' : $row['part'];
		echo '	<span class="aTitle"><a target="_blank" href="bookreader/templates/book.php?volume=' . $row['volume'] . '&part=' . $part . '&page=' . $row['page'] . '">' . $row['title'] . '</a></span><br />';
		if($row['authid'] != 0) {

			echo '<span class="aAuthor itl">by ';
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
else
{
	echo '<p class="sml mt-5 text-center">Sorry! No articles were found to begin with the letter \'' . $letter . '\' in Tattvaloka</p>';
}

if($result){$result->free();}
$db->close();

?>
			</div> 
		</div> 
	</main> 
<?php include("../inc/include_footer.php");?>
