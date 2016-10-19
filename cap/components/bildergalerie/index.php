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
include($_SERVER['DOCUMENT_ROOT']."/cap/include/modules/navigation/actionbar.php");

// output
$content.= '
			<div class="row">
				<div class="col-md-12">
				
					<div class="panel panel-default">
						<div class="panel-body">
							<button class="btn btn-success save">Reihenfolge speichern</button>&nbsp;<span id="response"></span>
						</div>
					</div>
				
					<ul class="sortable">';




/* fetch angebote		https://ssdtutorials.com/courses/sort-table-rows-jquery

with the demo: https://coderwall.com/p/okkzpa/sortable-gallery-to-database

----------------- */

$sql = "SELECT *
		FROM STRA_bildergalerie
		ORDER BY ord ASC";	
					
$result = mysql_query($sql,$db);




// loop thru




while( $array = @mysql_fetch_array( $result ) ){ //download every row into array
	$id = $array['id'];
	$photo_name = $array['bild'];
	
	$content.= '
						<li id="item-' .$id. '"><img src="/images/bildergalerie/' .$photo_name. '-t.jpg"></li>';
	
#	$content.= '
#							<tr>
#								<td>' .$id. '</td>
#								<td class="text-center">' .$kategorie. '</td>
#								<td><a href="edit.php?id=' .$id. '" title="edit: ' .$bild. '"><img src="/images/bildergalerie/' .$bild. '.jpg" width="90px"></a></td>
#								<td>
#									<div class="btn-group" role="group" aria-label="...">
#										<a href="edit.php?id=' .$id. '" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
#										<a href="edit.php?clone=' .$id. '&amp;url=' .$bild. '" class="btn btn-warning"><i class="fa fa-clone"></i></a>
#										<a href="index.php?trashid=' .$id. '&amp;titel=' .$bild. '" class="btn btn-danger"><i class="fa fa-trash"></i></a>
#									</div>
#								</td>
#							</tr>
#	';
	
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