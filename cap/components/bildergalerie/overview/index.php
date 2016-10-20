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
			<div class="row mt">
				<div class="col-lg-12">
					
					<form class="form-horizontal tasi-form" method="get">
					<table class="table table-striped table-hover table-condensed" id="offertable">
						<thead>
							<tr>
								<th>id</th>
								<th class="text-center">Kategorie(n)</th>
								<th>Bild</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody>';




/* fetch angebote
----------------- */

$sql = "SELECT id, kategorie, titel, bild
		FROM STRA_bildergalerie
		ORDER BY id DESC";	
					
$result = mysql_query($sql,$db);




// loop thru

while($row=mysql_fetch_array($result)){
	
	$id =			$row['id'];
	$titel =		$row['titel'];
	$kategorie =	$row['kategorie'];
	$bild =			$row['bild'];
	
	if($online==1){
		$status = '<span class="label label-success"><i class="fa fa-check fa-fw"></i></span>';
	}else{
		$status = '<span class="label label-danger"><i class="fa fa-times fa-fw"></i></span>';
	}
	
	$content.= '
							<tr>
								<th scope="row">' .$id. '</th>
								<td class="text-center">' .$kategorie. '</td>
								<td><a href="edit.php?id=' .$id. '" title="edit: ' .$bild. '"><img src="/images/bildergalerie/' .$bild. '.jpg" width="90px"></a></td>
								<td>
									<div class="btn-group" role="group" aria-label="...">
										<a href="edit.php?id=' .$id. '" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
										<a href="edit.php?clone=' .$id. '&amp;url=' .$bild. '" class="btn btn-warning"><i class="fa fa-clone"></i></a>
										<a href="index.php?trashid=' .$id. '&amp;titel=' .$bild. '" class="btn btn-danger"><i class="fa fa-trash"></i></a>
									</div>
								</td>
							</tr>
	';
	
}

$content.= '
						</tbody>
					</table>
					</form>
						
				</div>
			</div>
';




/* settings
----------- */

$template['meta_title'] = "Bildergalerie Übersicht";
$template['maincontent'] = $content;
$template['template'] = "site";
include ($template_pfad.$template['template'].".html");

?>