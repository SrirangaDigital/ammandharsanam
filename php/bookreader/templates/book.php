<!DOCTYPE HTML>
<html manifest="appcache.manifest">
<head>

    <title>BookReader</title>
    <meta charset="UTF-8"/>
    <link rel="shortcut icon" href="../../images/aplogo.ico">
    <link rel="stylesheet" type="text/css" href="../static/BookReader/BookReader.css"/>
    <link rel="stylesheet" type="text/css" href="../static/BookReaderDemo.css"/>
    <script type="text/javascript" src="../static/BookReader/jquery-1.4.2.min.js"></script>
    <!-- <script type="text/javascript" src="../static/BookReader/jquery-1.12.4.min.js"></script> -->
    <script type="text/javascript" src="../static/BookReader/jquery-ui-1.8.5.custom.min.js"></script>
    <script type="text/javascript " src="../static/BookReader/dragscrollable.js"></script>
    <script type="text/javascript" src="../static/BookReader/jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="../static/BookReader/jquery.ui.ipad.js"></script>
    <script type="text/javascript" src="../static/BookReader/jquery.bt.min.js"></script>
    <script type="text/javascript" src="../static/BookReader/BookReader.js"></script>
    
    <?php

		$volume = $_GET['volume'];
		$part = $_GET['part'];
		$page = $_GET['page'].".jpg";
		
		if(isset($_GET['searchText']) && $_GET['searchText']!='')
		{
			$search = $_GET['searchText'];
			$book["searchText"] = $search;
		}
		

		$imgUrl =  '../../../Volumes/jpg/2/' . $volume . '/' . $part;
		
		$imgList=scandir($imgUrl);
		$cmd='';
		
		for($i=0;$i<sizeof($imgList);$i++)
		{
			if($imgList[$i] != '.' && $imgList[$i] != '..')
			{
				$book["imglist"][$i]= $imgList[$i];
			}
		}

		$book["imglist"]=array_values($book["imglist"]);
		$book["Title"] = "Tattvaloka Magazine";
		$book["TotalPages"] = count($book["imglist"]);
		$book["SourceURL"] = "";
		$result = array_keys($book["imglist"], $page);
		$book["pagenum"] = $result[0];
		$book["volume"] = $volume;
		$book["part"] = $part;
		$book["imgurl"] = $imgUrl;
	    $book["bigImageUrl"] =  '../../../Volumes/jpg/1/' . $volume . '/' . $part;
    ?>
<script type="text/javascript">var book = <?php echo json_encode($book); ?>;</script>
<!-- <script>$.ajax({url: "filesRemover.php", async: true});</script> -->
</head>
<script type="text/javascript" src="../static/BookReader/cacheUpdater.js"></script>
<script type="text/javascript" src="../static/BookReader/checkCached.js"></script>

<body style="background-color: #939598;">

<div id="BookReader">
    
</div>
<script type="text/javascript" src="../static/BookReaderJSSimple.js"></script>
</body>
</html>
