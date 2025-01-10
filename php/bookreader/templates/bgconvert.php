<?php
	$index = $_GET['index'];
	$book_id = $_GET['book_id'];
	$imgurl = $_GET['imgurl'];
	$reduce = round($_GET['level']);
	$book = $_POST['book'];
	$img = preg_split("/\./",$book[$index]);
	$mode = $_GET['mode'];

	
	if($reduce == 1)
	{
		$pdfurl = '../../public/data/' . str_replace('_', '/',$book_id) . '/pdf';
		$imgurl = '../../public/data/' . str_replace('_', '/',$book_id) . '/jpg/1';


		$scale = 2100;

		
		if(file_exists($pdfurl)){
			
			$page = $img[0] . ".jpg";				
			$cmd = "convert -density 300 -resize x" . $scale . " " . $pdfurl . "/index.pdf\[" . $index . "\] -alpha remove " . $imgurl . "/". $page;
			exec($cmd);	
		}
		
	}
	$array['id'] = "#pagediv".$index;
	$array['mode'] = $mode;
	$array['img'] = $imgurl . "/" .$img[0] . ".jpg";


	echo json_encode($array);
	//~ Update manifest file to download the request file.
	$myfile = fopen("appcache.manifest", "w") or die("Unable to open file!!!");
	fwrite($myfile,"CACHE MANIFEST\n");
	fwrite($myfile,$imgurl."/".$img[0].".jpg");
	fwrite($myfile,"\n\nNETWORK:\n*\n");
	fwrite($myfile,"FALLBACK:\n");
	fclose($myfile);
?>
