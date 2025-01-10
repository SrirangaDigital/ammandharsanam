<?php include("../inc/include_header.php");?>
<main class="container-fluid maincontent">
        <div class="row justify-content-center gapAboveLarge">
            <div class="col-sm-12 col-md-8">
                <div class="extra-info-bar fixed-top">  
                    <h1 class="clr1 pt-5">Archive &gt; Search</h1>
<?php include("include_secondary_nav.php");?>
                </div>    
<?php

include("connect.php");
require_once("common.php");

?>
                <div class="archive_search gapAboveLarge">
                    <form method="get" action="search-result.php" class="row justify-content-center">
                        <div class="col-11 col-md-5">
                            <label for="textfield2" class="titlespan form-label">Title</label>
                            <input name="title" type="text" class="form-control titlespan wide" id="textfield2" maxlength="150"/>
                            <label for="autocomplete" class="form-label titlespan mt-2">Author</label>
                            <input name="author" type="text" class="form-control titlespan wide" id="autocomplete" maxlength="150" />
<?php
$query_ac = "select * from author order by authorname";
$result_ac = $db->query($query_ac);
$num_rows_ac = $result_ac ? $result_ac->num_rows : 0;
echo "<script type=\"text/javascript\">$( \"#autocomplete\" ).autocomplete({source: [ ";
$source_ac = '';
if($num_rows_ac > 0)
{
    for($i=1;$i<=$num_rows_ac;$i++)
    {
        $row_ac = $result_ac->fetch_assoc();
        $source_ac = $source_ac . ', '. '"' . $row_ac['authorname'] . '"';
    }
    $source_ac = preg_replace("/^\, /", "", $source_ac);
}

echo $source_ac . ']});</script>';
if($result_ac){$result_ac->free();}

?>
                        <label class="titlespan form-label mt-2">Category</label>
                        <select name="featid" class="form-select titlespan wide">
                            <option value="">&nbsp;</option>
<?php

$query = "select * from feature where feat_name != '' order by feat_name";
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
    for($i=1;$i<=$num_rows;$i++)
    {
        $row = $result->fetch_assoc();

        $feat_name=$row['feat_name'];
        $featid=$row['featid'];
        echo "<option value=\"$featid\">" . $feat_name . "</option>";
    }
}

if($result){$result->free();}

?>
                        </select>
                        <label for="textfield3" class="titlespan form-label mt-2">Words</label>
                        <input name="text" type="text" class="form-control titlespan wide" id="textfield3" maxlength="150"/>
                        <label class="titlespan form-label mt-4">Year</label>
                        <div class="input-group">
                            <select name="year1" class="form-select">
                                <option value="">&nbsp;</option>
<?php

$query = "select distinct year from article order by year";
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
    for($i=1;$i<=$num_rows;$i++)
    {
        $row = $result->fetch_assoc();

        $year=$row['year'];
        echo "<option value=\"$year\">" . $year . "</option>";
    }
}

if($result){$result->free();}

?>
                                    </select>
                                    <span class="small">&nbsp;to&nbsp;</span>
                                    <select name="year2" class="form-select">
                                        <option value="">&nbsp;</option>

<?php
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
    for($i=1;$i<=$num_rows;$i++)
    {
        $row = $result->fetch_assoc();

        $year=$row['year'];
        echo "<option value=\"$year\">" . $year . "</option>";
    }
}
if($result){$result->free();}
$db->close();
?>
                                    </select>
                                </div> 
                                <div class="btn-group mt-4 float-end">
                                    <input name="searchform" type="submit" class="btn btn-primary me-4" id="button_search" value="Search"/>
                                    <input name="resetform" type="reset" class="btn btn-primary" id="button_reset" value="Reset"/>
                                </div>
                        </div>    
                    </form>
                </div>
            </div> 
        </div> 
    </main> 
<?php include("../inc/include_footer.php");?>
