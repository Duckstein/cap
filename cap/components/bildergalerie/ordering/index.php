<?php

/* includes
----------- */

$include_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/";
$template_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/template/";

include($include_pfad."init.php");




/* routines
----------- */

// datensatz löschen
if($trashid){

	$content.= '
			<div class="row mt">
				<div class="col-lg-12">
					<div class="alert alert-danger alert-dismissible" role="alert">
						
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times; abbrechen</span></button>
						<h1>Sicher?</h1>
						<p class="lead"><b>' .$trashid. ' : ' .$titel. '</b> löschen?</p>
						<p><a href="index.php?deleteid=' .$trashid. '" class="btn btn-danger" type="submit" value="trash">Yep - hau wech!</a></p>
						
					</div>
				</div>
			</div>
	';
	
}

if($deleteid){

	$loeschen = "DELETE FROM STRA_bildergalerie WHERE id = $deleteid";
	$loesch = mysql_query($loeschen);
	
	$content.= '
			<div class="row mt">
				<div class="col-lg-12">
					<div class="alert alert-success alert-dismissible" role="alert">
						
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h1>Eintrag gelöscht</h1>
						
					</div>
				</div>
			</div>
	';
	
}
	



/* wrapper
---------- */

// actionbar
$content.= '
			<div class="row">
				<div class="col-md-12">
					<hr />
					<div class="btn-group" role="group" aria-label="...">
						<button class="btn btn-primary save">Reihenfolge speichern</button>
						<button class="btn btn-link disabled" id="response"></button>
					</div>
					<hr />
				</div>
			</div>';

// output
$content.= '
			<div class="row">
				<div class="col-md-12">
				
					<ul class="sortable">';




/* fetch angebote
----------------- */

$sql = "SELECT *
		FROM STRA_bildergalerie
		ORDER BY ord ASC";	
					
$result = mysql_query($sql,$db);




// loop thru
while( $array = @mysql_fetch_array( $result ) ){
	$id = $array['id'];
	$photo_name = $array['bild'];
	
	$content.= '
						<li id="item-' .$id. '"><img src="/images/bildergalerie/' .$photo_name. '-t.jpg"></li>';
}

$content.= '
					</ul>
						
				</div>
			</div>';




/* settings
----------- */

$template['meta_title'] = "Bildergalerie Übersicht";
$template['maincontent'] = $content;
$template['template'] = "site";
include ($template_pfad.$template['template'].".html");

?>