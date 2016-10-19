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

	$loeschen = "DELETE FROM deu_angebote WHERE id = $deleteid";
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
	
	$sqla = "UPDATE deu_angebote SET online='$newstatus' WHERE id='$id'";		
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
			<!-- hotelfilter -->
			<div class="row mt">
				<div class="col-lg-12">
					
					<form class="form-inline" method="get" action="index.php" target="_self">
						<div class="form-group">
							<label for="hot">Hotel </label>
							<select id="hot" name="hot" class="form-control">
								<option>alle Häuser</option>
								<option '; if($hot=='kuehl'){$content.= 'selected';} $content.= ' value="kuehl">01 kuehl</option>
								<option '; if($hot=='gif'){$content.= 'selected';} $content.= ' value="gif">02 gif</option>
								<option '; if($hot=='ise'){$content.= 'selected';} $content.= ' value="ise">03 ise</option>
								<option '; if($hot=='alex'){$content.= 'selected';} $content.= ' value="alex">06 alex</option>
								<option '; if($hot=='nord'){$content.= 'selected';} $content.= ' value="nord">07 nord</option>
								<option '; if($hot=='hof'){$content.= 'selected';} $content.= ' value="hof">08 goth</option>
								<option '; if($hot=='melle'){$content.= 'selected';} $content.= ' value="melle">09 melle</option>
								<option '; if($hot=='biho'){$content.= 'selected';} $content.= ' value="biho">10 biho</option>
								<option '; if($hot=='arend'){$content.= 'selected';} $content.= ' value="arend">11 arend</option>
								<option '; if($hot=='woer'){$content.= 'selected';} $content.= ' value="woer">12 woer</option>
								<option '; if($hot=='fuss'){$content.= 'selected';} $content.= ' value="fuss">13 fuss</option>
								<option '; if($hot=='stra'){$content.= 'selected';} $content.= ' value="stra">14a stra</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary"><i class="fa fa-filter fa-fw"></i> Filter</button>
					</form>
					
				</div>
			</div>
			<!-- /hotelfilter -->
			
			<hr />
			
			<div class="row mt">
				<div class="col-lg-12" id="example">
					
					<form class="form-horizontal tasi-form" method="get">
					<table class="table table-striped table-hover table-condensed" id="offertable">
						<thead>
							<tr>
								<th>id</th>
								<th class="text-center">online</th>
								<th>Hotel</th>
								<th>Angebot</th>
								<th>edit/clone/trash</th>
							</tr>
						</thead>
						<tbody>';




/* fetch angebote
----------------- */

switch($hot)
{
	case("kuehl"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'kuehl'
			ORDER BY id DESC";
	break;
	
	case("gif"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'gif'
			ORDER BY id DESC";
	break;
	
	case("ise"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'ise'
			ORDER BY id DESC";
	break;
	
	case("alex"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'alex'
			ORDER BY id DESC";
	break;
	
	case("nord"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'nord'
			ORDER BY id DESC";
	break;
	
	case("hof"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'hof'
			ORDER BY id DESC";
	break;
	
	case("melle"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'melle'
			ORDER BY id DESC";
	break;
	
	case("biho"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'biho'
			ORDER BY id DESC";
	break;
	
	case("arend"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'arend'
			ORDER BY id DESC";
	break;
	
	case("woer"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'woer'
			ORDER BY id DESC";
	break;
	
	case("fuss"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'fuss'
			ORDER BY id DESC";
	break;
	
	case("stra"):
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot = 'stra'
			ORDER BY id DESC";
	break;
	
	default:
	$sql = "SELECT id, hot, titel, online, ang
			FROM deu_angebote
			WHERE hot != 'mais' AND hot != 'jagd' AND hot != 'can' AND hot != 'ost' AND hot != 'stri'
			ORDER BY id DESC";
	break;
}	
					
$result = mysql_query($sql,$db);




// loop thru

while($row=mysql_fetch_array($result)){
	
	$id =		$row['id'];
	$hot =		$row['hot'];
	$titel =	$row['titel'];
	$online =	$row['online'];
	$ang = 		$row['ang'];
	
	if($online=='ja'){
		$status = '<a class="btn btn-success btn-xs" href="index.php?' .$queryString. '&amp;newstatus=nein&amp;id=' .$id. '" title="toggle on/offline"><i class="fa fa-check fa-fw"></i></a>';
	}else{
		$status = '<a class="btn btn-danger btn-xs" href="index.php?' .$queryString. '&amp;newstatus=ja&amp;id=' .$id. '" title="toggle off/online"><i class="fa fa-times fa-fw"></i></a>';
	}
	
	$content.= '
							<tr>
								<th scope="row">' .$id. '</th>
								<td class="text-center">' .$status. '</td>
								<td class="text-center">' .$hot. '</td>
								<td><a href="edit.php?id=' .$id. '" title="edit: ' .$titel. '">' .$titel. '</a></td>
								<td>
									<div class="btn-group" role="group" aria-label="...">
										<a href="edit.php?id=' .$id. '" class="btn btn-primary btn-xs" title="edit"><i class="fa fa-pencil fa-fw"></i></a>
										<a href="edit.php?clone=' .$id. '&amp;ang=' .$ang. '" class="btn btn-warning btn-xs" title="clone"><i class="fa fa-clone fa-fw"></i></a>
										<a href="index.php?trashid=' .$id. '&amp;titel=' .$titel. '" class="btn btn-danger btn-xs" title="trash"><i class="fa fa-trash fa-fw"></i></a>
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