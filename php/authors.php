<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent">
		<div class="row justify-content-center gapAboveLarge">
			<div class="col-sm-12 col-md-8">
				<div class="extra-info-bar fixed-top">	
					<h1 class="clr1 pt-5">Archive &gt; Authors</h1>
					<div class="alphabet">
						<span class="letter"><a href="authors.php?letter=A">A</a></span>
						<span class="letter"><a href="authors.php?letter=B">B</a></span>
						<span class="letter"><a href="authors.php?letter=C">C</a></span>
						<span class="letter"><a href="authors.php?letter=D">D</a></span>
						<span class="letter"><a href="authors.php?letter=E">E</a></span>
						<span class="letter"><a href="authors.php?letter=F">F</a></span>
						<span class="letter"><a href="authors.php?letter=G">G</a></span>
						<span class="letter"><a href="authors.php?letter=H">H</a></span>
						<span class="letter"><a href="authors.php?letter=I">I</a></span>
						<span class="letter"><a href="authors.php?letter=J">J</a></span>
						<span class="letter"><a href="authors.php?letter=K">K</a></span>
						<span class="letter"><a href="authors.php?letter=L">L</a></span>
						<span class="letter"><a href="authors.php?letter=M">M</a></span>
						<span class="letter"><a href="authors.php?letter=N">N</a></span>
						<span class="letter"><a href="authors.php?letter=O">O</a></span>
						<span class="letter"><a href="authors.php?letter=P">P</a></span>
						<span class="letter"><a href="authors.php?letter=Q">Q</a></span>
						<span class="letter"><a href="authors.php?letter=R">R</a></span>
						<span class="letter"><a href="authors.php?letter=S">S</a></span>
						<span class="letter"><a href="authors.php?letter=T">T</a></span>
						<span class="letter"><a href="authors.php?letter=U">U</a></span>
						<span class="letter"><a href="authors.php?letter=V">V</a></span>
						<span class="letter"><a href="authors.php?letter=W">W</a></span>
						<span class="letter"><a href="authors.php?letter=X">X</a></span>
						<span class="letter"><a href="authors.php?letter=Y">Y</a></span>
						<span class="letter"><a href="authors.php?letter=Z">Z</a></span>
						<span class="letter"><a href="authors.php?letter=Special">#</a></span>
					</div>
					<?php include("include_secondary_nav.php");?>
				</div>
			</div>
			<div class="col-sm-12 col-md-8 gapAboveLarge mbsm-5">
				<p>&nbsp;</p>
			</div>		
			
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['letter']))
{
	$letter=$_GET['letter'];

	if(!(isValidLetter($letter)))
	{
		echo '<span class="aFeature clr2">Invalid URL</span>';
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

//~ $query = 'select * from author where authorname like \'' . $letter . '%\' order by authorname';
if($letter == 'Special')
{
	$query = "select * from author where authorname not regexp '^[a-z]|^\'[a-z]|^\"[a-z]|^<|^\"<' order by authorname";
}
else
{
	$query = "select * from author where authorname like '$letter%' union select * from author where authorname like '\"$letter%' union select * from author where authorname like '\'$letter%' order by TRIM(BOTH '\'' FROM TRIM(BOTH '\"' FROM authorname))";
}

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		echo '<div class="col-sm-12 col-md-3">';
		echo '<div class="author">';
		echo '	<span class="aAuthor"><a href="auth.php?authid=' . $row['authid'] . '&amp;author=' . urlencode($row['authorname']) . '">' . $row['authorname'] . '</a>';
		echo '</div>';
		echo '</div>';
	}
}
else
{
	echo '<p class="sml mt-5 text-center clr2">Sorry! No author names were found to begin with the letter \'' . $letter . '\' in Tattvaloka</p>';
}

if($result){$result->free();}
$db->close();

?>
		</div> 
	</main> 
<?php include("../inc/include_footer.php");?>
