<?php

/* includes
----------- */

$include_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/";
$template_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/template/";

include($include_pfad."init.php");




/* url bestimmen
---------------- */

// benötigt für statusupdate
$queryString = strstr($_SERVER['REQUEST_URI'], '?');
$queryString = ($queryString===false) ? '' : substr($queryString, 1);




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

	$loeschen = "DELETE FROM STRA_angebote WHERE id = $deleteid";
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




// statusupdate
if($newstatus){
	
	$sqla = "UPDATE STRA_angebote SET online='$newstatus' WHERE id='$id'";		
	$resultata = mysql_query($sqla,$db) or die ("MySQL-Fehler: " . mysql_error());
	
	$content.= '
					<div class="row mt">
						<div class="col-lg-12">
							<div class="alert alert-success alert-dismissible" role="alert">
								
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h1>Updated id ' .$id. '</h1>
								
							</div>
						</div>
					</div>
	';
	
	// entfernt params aus uri
	$trim = array('&newstatus=', "&id=$id", 'ja', 'nein');
	$trimmed = str_replace($trim, "", $queryString);
	$queryString = $trimmed;
	
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
								<th class="text-center">online</th>
								<th>Angebot</th>
								<th>Teaser</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody>';




/* fetch angebote
----------------- */

$sql = "SELECT id, url, teaser, titel, online
		FROM STRA_angebote
		ORDER BY id DESC";	
					
$result = mysql_query($sql,$db);




// loop thru

while($row=mysql_fetch_array($result)){
	
	$id =		$row['id'];
	$url =		$row['url'];
	$titel =	$row['titel'];
	$online =	$row['online'];
	$teaser =	$row['teaser'];
	
	if($online=='ja'){
		$status = '<a class="btn btn-success btn-xs" href="index.php?' .$queryString. '&amp;newstatus=nein&amp;id=' .$id. '" title="toggle on/offline"><i class="fa fa-check fa-fw"></i></a>';
	}else{
		$status = '<a class="btn btn-danger btn-xs" href="index.php?' .$queryString. '&amp;newstatus=ja&amp;id=' .$id. '" title="toggle off/online"><i class="fa fa-times fa-fw"></i></a>';
	}
	
	$content.= '
							<tr>
								<th scope="row">' .$id. '</th>
								<td class="text-center">' .$status. '</td>
								<td><a href="edit.php?id=' .$id. '" title="edit: ' .$titel. '">' .$titel. '</a></td>
								<td><span class="label label-default">' .$teaser. '</span></td>
								<td>
									<div class="btn-group" role="group" aria-label="...">
										<a href="edit.php?id=' .$id. '" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
										<a href="edit.php?clone=' .$id. '&amp;url=' .$url. '" class="btn btn-warning btn-xs"><i class="fa fa-clone"></i></a>
										<a href="index.php?trashid=' .$id. '&amp;titel=' .$titel. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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

$template['meta_title'] = "Angebote Übersicht";
$template['maincontent'] = $content;
$template['template'] = "site";
include ($template_pfad.$template['template'].".html");

?>