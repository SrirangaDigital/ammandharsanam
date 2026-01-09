<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent">
		<div class="row justify-content-center gapAboveLarge">
			<div class="col-sm-12 col-md-8">
				<div class="extra-info-bar fixed-top">	
					<h1 class="clr1 pt-5">மலர்கள் &gt; ஆசிரியர்கள்</h1>
					<div class="alphabet">
						<span class="letter"><a href="authors.php?letter=அ">அ</a></span>
						<span class="letter"><a href="authors.php?letter=ஆ">ஆ</a></span>
						<span class="letter"><a href="authors.php?letter=இ">இ</a></span>
						<span class="letter"><a href="authors.php?letter=ஈ">ஈ</a></span>
						<span class="letter"><a href="authors.php?letter=உ">உ</a></span>
						<span class="letter"><a href="authors.php?letter=ஊ">ஊ</a></span>
						<span class="letter"><a href="authors.php?letter=எ">எ</a></span>
						<span class="letter"><a href="authors.php?letter=ஏ">ஏ</a></span>
						<span class="letter"><a href="authors.php?letter=ஐ">ஐ</a></span>
						<span class="letter"><a href="authors.php?letter=ஒ">ஒ</a></span>
						<span class="letter"><a href="authors.php?letter=ஓ">ஓ</a></span>
						<span class="letter"><a href="authors.php?letter=ஔ">ஔ</a></span>
						<span class="letter"><a href="authors.php?letter=க">க</a></span>
						<span class="letter"><a href="authors.php?letter=ங">ங</a></span>
						<span class="letter"><a href="authors.php?letter=ச">ச</a></span>
						<span class="letter"><a href="authors.php?letter=ஜ">ஜ</a></span>
						<span class="letter"><a href="authors.php?letter=ஞ">ஞ</a></span>
						<span class="letter"><a href="authors.php?letter=ட">ட</a></span>
						<span class="letter"><a href="authors.php?letter=ண">ண</a></span>
						<span class="letter"><a href="authors.php?letter=த">த</a></span>
						<span class="letter"><a href="authors.php?letter=ந">ந</a></span>
						<span class="letter"><a href="authors.php?letter=ன">ன</a></span>
						<span class="letter"><a href="authors.php?letter=ப">ப</a></span>
						<span class="letter"><a href="authors.php?letter=ம">ம</a></span>
						<span class="letter"><a href="authors.php?letter=ய">ய</a></span>
						<span class="letter"><a href="authors.php?letter=ர">ர</a></span>
						<span class="letter"><a href="authors.php?letter=ற">ற</a></span>
						<span class="letter"><a href="authors.php?letter=ல">ல</a></span>
						<span class="letter"><a href="authors.php?letter=ள">ள</a></span>
						<span class="letter"><a href="authors.php?letter=ழ">ழ</a></span>
						<span class="letter"><a href="authors.php?letter=வ">வ</a></span>
						<span class="letter"><a href="authors.php?letter=ஶ">ஶ</a></span>
						<span class="letter"><a href="authors.php?letter=ஷ">ஷ</a></span>
						<span class="letter"><a href="authors.php?letter=ஸ">ஸ</a></span>
						<span class="letter"><a href="authors.php?letter=ஹ">ஹ</a></span>
						<span class="letter"><a href="authors.php?letter=other">#</a></span>
					</div>
					<?php include("include_secondary_nav.php");?>
				</div>
			</div>
			<div class="col-sm-12 col-md-8 gapAbove gapBelowLargeSpecial">
				<p class="mb-sm-5">&nbsp;</p>
			</div>
		</div>			
		<div class="row justify-content-center">	
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

	($letter == '') ? $letter = 'அ' : $letter = $letter;
}
else
{
	$letter = 'அ';
}

//~ $query = 'select * from author where authorname like \'' . $letter . '%\' order by authorname';
if($letter == 'other')
{
	$query = "SELECT * FROM author WHERE authorname REGEXP '^[A-Za-z]'";
}
else
{
	$query = "select * from author where authorname like '$letter%'  union select * from author where authorname like '\"$letter%' union select * from author where authorname like '\'$letter%' order by TRIM(BOTH '\'' FROM TRIM(BOTH '\"' FROM authorname))";
}

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;
$firstEntry = true;

if($num_rows > 0)
{

	while($row = $result->fetch_assoc())
	{
		{
		echo '<div class="author text-left">';
		echo '	<span class="aAuthor"><a href="auth.php?authid=' . $row['authid'] . '&amp;author=' . urlencode($row['authorname']) . '">' . $row['authorname'] . '</a> ';
		echo '</div>';
	}
	}
}
else
{
	// echo '<p class="sml mt-5 text-center clr2">ಇಲ್ಲಿ \'' . $letter . '\' ಅಕ್ಷರದಿಂದ ಪ್ರಾರಂಭವಾಗುವ ಹೆಸರಿನ ಲೇಖಕರಿಲ್ಲ</p>';
	echo '<p class="sml mt-5 text-center clr2">கடிதம் \'' . $letter . '\' என்று ஆரம்பத்தில் எந்த ஆசிரியர்கள் உள்ளன';
}

if($result){$result->free();}
$db->close();

?>
		</div> 
	</main> 
<?php include("../inc/include_footer.php");?>
