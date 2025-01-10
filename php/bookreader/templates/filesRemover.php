<?php
	$jpg = 'find ../../public/data/001/[0-9][0-9][0-9]/jpg/1/ +mmin 10 -type f -name "*.jpg" -exec rm {} \;';
	exec($jpg);
?>
