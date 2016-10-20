<?php

/* --------------------------------- *\

	saves img-ordering to db
	
	v1.0	2016-10-20 | jd

\* --------------------------------- */




/* includes
----------- */

$include_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/";
$template_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/template/";

include($include_pfad."init.php");




/* update ordering to db
------------------------ */

if(isset($_POST)){

	$array_items = $_POST['item'];
	$order = 0;

	foreach ($array_items as $item) {

		$update = "UPDATE STRA_bildergalerie SET ord = '$order' WHERE id='$item' ";
		$perform = mysql_query( $update );

		$order++;
		echo mysql_error();
	}

}

?>