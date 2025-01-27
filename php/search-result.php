<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent">
        <div class="row justify-content-center gapAboveLarge">
            <div class="col-sm-12 col-md-8">
                <div class="extra-info-bar fixed-top">  
                    <h1 class="clr1 pt-5">Archive &gt; Search Results</h1>
<?php include("include_secondary_nav.php");?>
                </div>    
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['author'])){$author = $_GET['author'];}else{$author = '';}
if(isset($_GET['text'])){$text = $_GET['text'];}else{$text = '';}
if(isset($_GET['title'])){$title = $_GET['title'];}else{$title = '';}
if(isset($_GET['featid'])){$featid = $_GET['featid'];}else{$featid = '';}
if(isset($_GET['year1'])){$year1 = $_GET['year1'];}else{$year1 = '';}
if(isset($_GET['year2'])){$year2 = $_GET['year2'];}else{$year2 = '';}

$text = entityReferenceReplace($text);
$author = entityReferenceReplace($author);
$title = entityReferenceReplace($title);
$featid = entityReferenceReplace($featid);
$year1 = entityReferenceReplace($year1);
$year2 = entityReferenceReplace($year2);

$author = preg_replace("/[,\-]+/", " ", $author);
$author = preg_replace("/[\t]+/", " ", $author);
$author = preg_replace("/[ ]+/", " ", $author);
$author = preg_replace("/^ +/", "", $author);
$author = preg_replace("/ +$/", "", $author);
$author = preg_replace("/  /", " ", $author);
$author = preg_replace("/  /", " ", $author);

$title = preg_replace("/[,\-]+/", " ", $title);
$title = preg_replace("/[\t]+/", " ", $title);
$title = preg_replace("/[ ]+/", " ", $title);
$title = preg_replace("/^ +/", "", $title);
$title = preg_replace("/ +$/", "", $title);
$title = preg_replace("/  /", " ", $title);
$title = preg_replace("/  /", " ", $title);

$text = preg_replace("/[,\-]+/", " ", $text);
$text = preg_replace("/[\t]+/", " ", $text);
$text = preg_replace("/[ ]+/", " ", $text);
$text = preg_replace("/^ +/", "", $text);
$text = preg_replace("/ +$/", "", $text);
$text = preg_replace("/  /", " ", $text);
$text = preg_replace("/  /", " ", $text);

if($title=='')
{
    $title='[a-z]*';
}
if($author=='')
{
    $author='[a-z]*';
}
if($featid=='')
{
    $featid='[a-z]*';
}

($year1 == '') ? $year1 = 1914 : $year1 = $year1;
($year2 == '') ? $year2 = date('Y') : $year2 = $year2;

if($year2 < $year1)
{
    $tmp = $year1;
    $year1 = $year2;
    $year2 = $tmp;
}

$authorFilter = '';
$titleFilter = '';

$authors = preg_split("/ /", $author);
$titles = preg_split("/ /", $title);

for($ic=0;$ic<sizeof($authors);$ic++)
{
    $authorFilter .= "and authorname REGEXP '" . $authors[$ic] . "' ";
}
for($ic=0;$ic<sizeof($titles);$ic++)
{
    $titleFilter .= "and title REGEXP '" . $titles[$ic] . "' ";
}

$authorFilter = preg_replace("/^and /", "", $authorFilter);
$titleFilter = preg_replace("/^and /", "", $titleFilter);
$titleFilter = preg_replace("/ $/", "", $titleFilter);

if($text=='')
{
    $query="SELECT * FROM
                (SELECT * FROM
                    (SELECT * FROM
                        (SELECT * FROM article WHERE $authorFilter) AS tb1
                    WHERE $titleFilter) AS tb2
                WHERE featid REGEXP '$featid') AS tb3
            WHERE year between $year1 and $year2 ORDER BY volume, part, page";

}
elseif($text!='')
{
    $text = rtrim($text);
    if(preg_match("/^\"/", $text)) {

        $stext = preg_replace("/\"/", "", $text);
        $dtext = $stext;
        $stext = '"' . $stext . '"';
    }
    elseif(preg_match("/\+/", $text)) {

        $stext = preg_replace("/\+/", " +", $text);
        $dtext = preg_replace("/\+/", "|", $text);
        $stext = '+' . $stext;
    }
    elseif(preg_match("/\|/", $text)) {

        $stext = preg_replace("/\|/", " ", $text);
        $dtext = $text;
    }
    else {

        $stext = $text;
        $dtext = $stext = preg_replace("/ /", "|", $text);
    }
    
    $stext = addslashes($stext);
    
    $query="SELECT * FROM
                (SELECT * FROM
                    (SELECT * FROM
                        (SELECT * FROM
                            (SELECT *, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC) AS tb1
                        WHERE $authorFilter) AS tb2
                    WHERE $titleFilter) AS tb3
                WHERE featid REGEXP '$featid') AS tb4
            WHERE year between $year1 and $year2 ORDER BY volume, part, cur_page";
}

$result = $db->query($query); 
$num_results = $result ? $result->num_rows : 0;

if ($num_results > 0)
{
    echo '<div class="count gapAboveLarge">' . $num_results;
    echo ($num_results > 1) ? ' results' : ' result';
    echo '</div>';
}

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;
$id = 0;

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

        if ((strcmp($id, $row['titleid'])) != 0) {

            echo ($id == "0") ? '<div class="article">' : '</div><div class="article">';

            echo '  <div class="gapBelowSmall">';
            echo ($row3['feat_name'] != '') ? '     <span class="aFeature clr2"><a href="feat.php?feature=' . urlencode($row3['feat_name']) . '&amp;featid=' . $row['featid'] . '">' . $row3['feat_name'] . '</a></span> | ' : '';
            echo '      <span class="aIssue clr5"><a href="toc.php?vol=' . $row['volume'] . '&amp;part=' . $row['part'] . '">' . getMonth($row['month']) . ' ' . $row['year'] . '  (Volume ' . intval($row['volume']) . ', Issue ' . $dpart . ')</a></span>';
            echo '  </div>';
            echo '  <span class="aTitle"><a target="_blank" href="bookreader/templates/book.php?volume=' . $row['volume'] . '&part=' . $row['part'] . '&page=' . $row['page'] . '">' . $row['title'] . '</a></span>';
            if($row['authid'] != 0) {

                echo '  <br /><span class="aAuthor itl">by ';
                $authids = preg_split('/;/',$row['authid']);
                $authornames = preg_split('/;/',$row['authorname']);
                $a=0;
                foreach ($authids as $aid) {

                    echo '<a href="auth.php?authid=' . $aid . '&amp;author=' . urlencode($authornames[$a]) . '">' . $authornames[$a] . '</a> ';
                    $a++;
                }
				
                echo '  </span>';
            }
            if($text != '')
            {
                echo '<br /><span class="aIssue">Text match found at page(s) : </span>';
                echo '<span class="aIssue"><a target="_blank" href="bookreader/templates/book.php?volume=' . $row['volume'] . '&part=' . $row['part'] . '&page=' . $row['cur_page'] . '">' . intval($row['cur_page']) . '</a></span>';
            }
            $id = $row['titleid'];
        }
        else {
            if($text != '')
            {
                echo '&nbsp;<span class="aIssue"><a target="_blank" href="bookreader/templates/book.php?volume=' . $row['volume'] . '&part=' . $row['part'] . '&page=' . $row['cur_page'] . '">' . intval($row['cur_page']) . '</a></span>';
            }
            $id = $row['titleid'];
        }
    }
}
else
{
    echo '<p class="gapAboveLarge text-center mt-5"><a href="search.php" class="sml clr2">Sorry! No results. Hit the back button or click here to try again.</a></p>';
}

if($result){$result->free();}
$db->close();

?>
                </div> <!-- article card -->
            </div>
        </div>
    </main>
<?php include("../inc/include_footer.php");?>
