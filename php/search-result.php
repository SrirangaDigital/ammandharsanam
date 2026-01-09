<?php include("../inc/include_header.php"); ?>
<main class="container-fluid maincontent">
<div class="row justify-content-center gapAboveLarge">
<div class="col-sm-12 col-md-8">
<div class="extra-info-bar fixed-top">
    <h1 class="clr1 pt-5">தேடல்</h1>
    <?php include("include_secondary_nav.php"); ?>
</div>

<?php

include("connect.php");
require_once("common.php");

/* ------------------------- INPUTS ------------------------- */

$author = isset($_GET['author']) ? trim($_GET['author']) : "";
$title  = isset($_GET['title'])  ? trim($_GET['title'])  : "";
$text   = isset($_GET['text'])   ? trim($_GET['text'])   : "";
$featid = isset($_GET['featid']) ? trim($_GET['featid']) : "";
$year1  = isset($_GET['year1'])  ? trim($_GET['year1'])  : "";
$year2  = isset($_GET['year2'])  ? trim($_GET['year2'])  : "";

if (
    $title === "" &&
    $author === "" &&
    $text === "" &&
    $featid === "" &&
    $year1 === "" &&
    $year2 === ""
) {
    echo '<p class="gapAboveLarge text-center mt-5 clr2">
            Please enter at least one search criteria.
          </p>';
    include("../inc/include_footer.php");
    exit;
}



/* Cleanup */
$author = preg_replace("/\s+/", " ", $author);
$title  = preg_replace("/\s+/", " ", $title);

/* ------------------------- QUERY BUILD ------------------------- */

$conditions = [];
$params = [];

/* --- Title Filter (optional) --- */
if ($title !== "") {
    $words = explode(" ", $title);
    foreach ($words as $w) {
        $conditions[] = "title REGEXP ?";
        $params[] = $w;
    }
}

/* --- Author Filter (optional) --- */
if ($author !== "") {
    $words = explode(" ", $author);
    foreach ($words as $w) {
        $conditions[] = "authorname REGEXP ?";
        $params[] = $w;
    }
}

/* --- Feature Filter (optional) --- */
if ($featid !== "") {
    $conditions[] = "featid REGEXP ?";
    $params[] = $featid;
}

/* --- Year Filter ONLY if selected --- */
if ($year1 !== "" && $year2 !== "") {
    if ($year2 < $year1) { $tmp = $year1; $year1 = $year2; $year2 = $tmp; }
    $conditions[] = "year BETWEEN ? AND ?";
    array_push($params, $year1, $year2);
}

/* ------------------------- TEXT SEARCH ------------------------- */

$textSearch = false;
if ($text !== "") {
    $textSearch = true;

    // Build MATCH AGAINST logic
    if (preg_match('/^"/', $text)) {
        $stext = str_replace('"', '', $text);
        $stext = '"' . $stext . '"';
    } else if (strpos($text, '+') !== false) {
        $stext = '+' . str_replace("+", " +", $text);
    } else if (strpos($text, '|') !== false) {
        $stext = str_replace("|", " ", $text);
    } else {
        $stext = preg_replace("/ /", "|", $text);
    }

    $stext = addslashes($stext);

    $textSQL = "
        SELECT *, MATCH(text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance 
        FROM searchtable 
        WHERE MATCH(text) AGAINST ('$stext' IN BOOLEAN MODE)
    ";
}

/* ------------------------- FINAL QUERY ------------------------- */

$whereSQL = count($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

if(!$textSearch) {

    /* --- Normal TITLE / AUTHOR search query --- */
    $sql = "SELECT * FROM article $whereSQL ORDER BY volume, part, page";

} else {

    /* --- TEXT SEARCH with filters added --- */
    $sql = "
        SELECT * FROM (
            $textSQL
        ) AS t1
        $whereSQL
        ORDER BY relevance DESC, volume, part, cur_page
    ";
}

/* ------------------------- EXECUTE QUERY ------------------------- */

$stmt = $db->prepare($sql);

/* bind parameters */
if (count($params) > 0) {
    $types = str_repeat("s", count($params)); 
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$num_results = $result ? $result->num_rows : 0;

/* ------------------------- RESULTS COUNT ------------------------- */

if ($num_results > 0) {
    echo '<div class="count gapAboveLarge">'.$num_results;
    echo ($num_results > 1) ? ' results' : ' result';
    echo '</div>';
}

/* ------------------------- PRINT RESULTS ------------------------- */

$id = 0;

while ($row = $result->fetch_assoc()) {

    /* fetch feature name */
    $res3 = $db->query("SELECT feat_name FROM feature WHERE featid='".$row['featid']."'");
    $row3 = $res3->fetch_assoc();

    $dpart = preg_replace("/^0/", "", $row['part']);
    $sumne = explode('-', $row['page']);
    $row['page'] = $sumne[0];

    /* new article block */
    if ($id != $row['titleid']) {

        echo ($id == 0) ? '<div class="article">' : '</div><div class="article">';

        echo '<div class="gapBelowSmall">';

        if ($row3['feat_name'] != "") {
            echo '<span class="aFeature clr2"><a href="feat.php?feature='.urlencode($row3['feat_name']).'&featid='.$row['featid'].'">'.$row3['feat_name'].'</a></span> | ';
        }

        echo '<span class="aIssue clr5"><a href="toc.php?vol='.$row['volume'].'&part='.$row['part'].'">';
        echo ($row['part'] == '99')
                ? 'மலர் '.intval($row['volume']).', இதழ்'
                : 'மலர் '.intval($row['volume']).', இதழ் '.$dpart;
        echo '</a></span></div>';

        $part = ($row['part']=='99') ? 'இதழ்' : $row['part'];

        echo '<span class="aTitle"><a target="_blank" href="bookreader/templates/book.php?volume='.$row['volume'].'&part='.$part.'&page='.$row['page'].'">'.$row['title'].'</a></span>';

        if ($row['authid'] != 0) {
            echo '<br><span class="aAuthor itl">&mdash; ';
            $authids = explode(";", $row['authid']);
            $authornames = explode(";", $row['authorname']);
            foreach ($authids as $idx => $aid) {
                echo '<a class="delim" href="auth.php?authid='.$aid.'&author='.urlencode($authornames[$idx]).'">'.$authornames[$idx].'</a> ';
            }
            echo '</span>';
        }

        if ($textSearch) {
            echo '<br><span class="aIssue">Text match at page : ';
            echo '<a target="_blank" href="bookreader/templates/book.php?volume='.$row['volume'].'&part='.$row['part'].'&page='.$row['cur_page'].'">'.intval($row['cur_page']).'</a></span>';
        }

        $id = $row['titleid'];
    }
}

if ($num_results == 0) {
    echo '<p class="gapAboveLarge text-center mt-5"><a href="search.php" class="sml clr2">Sorry! No results. Try again.</a></p>';
}

?>
</div>
</div>
</div>
</main>
<?php include("../inc/include_footer.php"); ?>
