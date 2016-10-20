<?php

/* --------------------------------- *\

	BILDERGALERIE
	
	v1.0	2016-04-11 | jd

\* --------------------------------- */




/* includes
----------- */

$include_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/";
$template_pfad = $_SERVER['DOCUMENT_ROOT']."/cap/include/template/";

include($include_pfad."init.php");




/* wrapper
---------- */

// actionbar
include($_SERVER['DOCUMENT_ROOT']."/cap/include/modules/navigation/actionbar.php");

// output
$content.= '
			<script type="text/javascript" src="/cap/assets/tinymce/tinymce.min.js"></script>  
			<script type="text/javascript">
				
				tinymce.init({
					selector: "#bild",
					language: "de",
					inline: true,
					menubar: false,
					plugins : "responsivefilemanager code",
					toolbar: "| responsivefilemanager | undo redo | code",
					image_advtab: true ,
   
				   external_filemanager_path:"/cap/assets/filemanager/",
				   filemanager_title:"Responsive Filemanager" ,
				   external_plugins: { "filemanager" : "/cap/assets/filemanager/plugin.min.js"}
				});
				
			</script>
';




if($id){
	
	$content.= '
			<div class="row mt">
				<div class="col-lg-12">';
	
}else{
	
	$content.= '
			<div class="row mt">
				<div class="col-lg-12">';
	
}




/* routines
----------- */

// clone
if($clone){
	
	$unique = time();

	$sql = "CREATE TEMPORARY TABLE tmp SELECT * FROM STRA_bildergalerie WHERE id = $clone";
	$resultat = mysql_query($sql) or die ("MySQL-Fehler: " . mysql_error());
	
	$sql = "UPDATE tmp SET id = null, titel = '$unique'";
	$resultat = mysql_query($sql,$db) or die ("MySQL-Fehler: " . mysql_error());
	
	$sql = "INSERT INTO STRA_bildergalerie SELECT * FROM tmp";
	$resultat = mysql_query($sql,$db) or die ("MySQL-Fehler: " . mysql_error());
			
}




// update
if($edited=="1"){

	/* trim filename from responsivefilemanager
	------------------------------------------- */

	$trim = array('<p><img src="../../../../images/bildergalerie/', '.jpg', '"', ' /></p>');
	
	$trimmed = str_replace($trim, "", $bild);
	$zeichen = preg_split('/ alt=/', $trimmed, -1, PREG_SPLIT_OFFSET_CAPTURE);
	foreach ($zeichen as $key => $wert)
	$bild = $wert[0];
	
	
	
	
	/* fill categorie
	----------------- */
	
	// ... quick'n'dirty ... it'a TO DO ...
	$kategorie = $galerie. ' ' .$restaurant. ' ' .$hotelbar. ' ' .$dachterasse. ' ' .$raucherlounge. ' ' .$kuebomare. ' ' .$meerwasserwelt. ' ' .$saunawelt. ' ' .$fitnessbereich. ' ' .$balticospa;
	
	

	
	/* create thumbnail if image is new
	----------------------------------- */
	
	$gothumb = "../../../images/bildergalerie/" .$bild. ".jpg";
	$filename = "../../../images/bildergalerie/" .$bild. "-t.jpg";
	
	if (!file_exists($filename)){
		
		// set thumbnail width and height
		$new_w = 500;
		$new_h = 500;
		
		$src_img=imagecreatefromjpeg($gothumb);
		
		// calc and keep ratio
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		
		if ($old_x > $old_y){
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y){
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y){
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		
		// create thumb, save and destroy
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		
		imagejpeg($dst_img,$filename);
		
		imagedestroy($dst_img); 
		imagedestroy($src_img);
	}
	
	
	
	
	
	
	if($id){

		$sqla = "UPDATE STRA_bildergalerie SET kategorie='$kategorie', titel='$titel', beschreibung='$beschreibung', bild='$bild' WHERE id='$id'";		
		$resultata = mysql_query($sqla,$db) or die ("MySQL-Fehler: " . mysql_error());
		
		$content.= '
						<div class="row mt">
							<div class="col-lg-12">
								<div class="alert alert-success alert-dismissible" role="alert">
									
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h1>Updated</h1>
									
								</div>
							</div>
						</div>
		';
		
	}else{
		
		$sqla = "INSERT INTO STRA_bildergalerie (kategorie, titel, beschreibung, bild) VALUES ('$kategorie', '$titel', '$beschreibung', '$bild')";		
		$resultata = mysql_query($sqla,$db) or die ("MySQL-Fehler: " . mysql_error());
		
		$content.= '
						<div class="row mt">
							<div class="col-lg-12">
								<div class="alert alert-success alert-dismissible" role="alert">
									
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h1>Gespeichert</h1>
									
								</div>
							</div>
						</div>
		';
		
	}
}




/* fetch object
--------------- */

if(!$new){

	if($clone){
		
		$sql = "SELECT *
				FROM STRA_bildergalerie
				WHERE titel like '%$unique%'";
				
	}else{
		
		$sql = "SELECT *
				FROM STRA_bildergalerie
				WHERE id like '$id'";
				
	}
						
	$result = mysql_query($sql,$db);
	
	$row = mysql_fetch_array($result);
	
	$id =			$row['id'];
	$kategorie =	$row['kategorie'];
	$titel =		$row['titel'];
	$beschreibung =	$row['beschreibung'];
	$bild =			$row['bild'];

}




// edit
$content.= '
					<form class="form-horizontal" method="get" action="edit.php" target="_self">
					
						<div class="form-group">
							<label for="titel" class="col-sm-2 control-label">Titel</label>
							<div class="col-sm-10">
								<input id="titel" class="form-control round-form" type="text" value="' .$titel. '" name="titel">
							</div>
						</div>
						
						<div class="form-group">
							<label for="beschreibung" class="col-sm-2 control-label">Beschreibung</label>
							<div class="col-sm-10">
								<input id="beschreibung" class="form-control round-form" type="text" value="' .$beschreibung. '" name="beschreibung">
							</div>
						</div>
						
						<div class="form-group">
							<label for="kategorie" class="col-sm-2 control-label">Kategorie(n)</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="checkbox"><label><input type="checkbox" value="galerie" id="galerie" name="galerie"'; if(preg_match("/galerie/",$kategorie)) $content.=' checked';
										$content.='>Galerie</label></label></div>
									</div>
									<div class="col-sm-4">
										<div class="checkbox"><label><input type="checkbox" value="restaurant" id="restaurant" name="restaurant"'; if(preg_match("/restaurant/",$kategorie)) $content.=' checked';
										$content.='>Restaurant</label></div>
										<div class="checkbox"><label><input type="checkbox" value="hotelbar" id="hotelbar" name="hotelbar"'; if(preg_match("/hotelbar/",$kategorie)) $content.=' checked';
										$content.='>Hotelbar</label></div>
										<div class="checkbox"><label><input type="checkbox" value="dachterasse" id="dachterasse" name="dachterasse"'; if(preg_match("/dachterasse/",$kategorie)) $content.=' checked';
										$content.='>Dachterasse</label></div>
										<div class="checkbox"><label><input type="checkbox" value="raucherlounge" id="raucherlounge" name="raucherlounge"'; if(preg_match("/raucherlounge/",$kategorie)) $content.=' checked';
										$content.='>Raucher-Lounge</label></div>
									</div>
									<div class="col-sm-4">
										<div class="checkbox"><label><input type="checkbox" value="kuebomare" id="kuebomare" name="kuebomare"'; if(preg_match("/kuebomare/",$kategorie)) $content.=' checked';
										$content.='>Kübomare</label></div>
										<div class="checkbox"><label><input type="checkbox" value="meerwasserwelt" id="meerwasserwelt" name="meerwasserwelt"'; if(preg_match("/meerwasserwelt/",$kategorie)) $content.=' checked';
										$content.='>Meerwasserwelt</label></div>
										<div class="checkbox"><label><input type="checkbox" value="saunawelt" id="saunawelt" name="saunawelt"'; if(preg_match("/saunawelt/",$kategorie)) $content.=' checked';
										$content.='>Saunawelt</label></div>
										<div class="checkbox"><label><input type="checkbox" value="fitnessbereich" id="fitnessbereich" name="fitnessbereich"'; if(preg_match("/fitnessbereich/",$kategorie)) $content.=' checked';
										$content.='>Fitnessbereich</label></div>
										<div class="checkbox"><label><input type="checkbox" value="balticospa" id="balticospa" name="balticospa"'; if(preg_match("/balticospa/",$kategorie)) $content.=' checked';
										$content.='>Báltico Spa</label></div>
									</div>
								</div>
							
							</div>
						</div>
						
						<div class="form-group">
							<label for="bild" class="col-sm-2 control-label">Bild</label>
							<div class="col-sm-6">
								<div id="bild" name="bild"><p><img class="img-responsive" data-mce-src="../../../../images/bildergalerie/' .$bild. '.jpg" alt="' .$bild. '" src="../../../../images/bildergalerie/' .$bild. '.jpg"></p></div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-refresh"></i> Update</button>
							</div>
						</div>
						
						<input type="hidden" name="id" value="' .$id. '">
						<input type="hidden" name="edited" value="1">
						
					</form>


				</div>
			</div>';




/* settings
----------- */

$template['meta_title'] = "Bildergalerie";
$template['maincontent'] = $content;
$template['template'] = "site";
include ($template_pfad.$template['template'].".html");

?>