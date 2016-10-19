<?php

/* includes
----------- */

$host = 'localhost'; // your host
$db_user = 'usr_web16_1'; //database user name
$db_password = 'mbo6_32I'; //database password
$db_name = 'web16_stra'; //database name
$db_table = 'STRA_bildergalerie'; //your table name where you want to set the order


$connection = mysql_connect($host, $db_user, $db_password) or die('Failed'); //establish DB connection
$connect_to_db = mysql_select_db($db_name, $connection);
echo mysql_error();




/* save order
------------- */

if(isset($_POST)){

	$array_items = $_POST['item']; //array of items in the Unordered List
	$order = 0; //order number set to 0; 

	foreach ($array_items as $item) {

		$update = "UPDATE $db_table SET ord = '$order' WHERE id='$item' "; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.
		$perform = mysql_query( $update ); //perform the update

		$order++; //increment order value by one;
		echo mysql_error();
	}

}

?>