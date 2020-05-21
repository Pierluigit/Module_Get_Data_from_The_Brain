<?php
///////////////////////////////////////////
///////////////////////////////////////////
/////// Modular Project The Brain /////////
///////////////////////////////////////////
///////////////////////////////////////////
// Title: Display Import
// Data Juggler: Pierluigi
// Support: intelligenza@protonmail.com
// Date: April 2020
///////////////////////////////////////////
/*
.     .       .  .   . .   .   . .    +  .
  .     .  :     .    .. :. .___---------___.
       .  .   .    .  :.:. _".^ .^ ^.  '.. :"-_. .
    .  :       .  .  .:../:            . .^  :.:\.
        .   . :: +. :.:/: .   .    .        . . .:\
 .  :    .     . _ :::/:               .  ^ .  . .:\
  .. . .   . - : :.:./.                        .  .:\
  .      .     . :..|:                    .  .  ^. .:|
    .       . : : ..||        .                . . !:|
  .     . . . ::. ::\(                           . :)/
 .   .     : . : .:.|. ######              .#######::|
  :.. .  :-  : .:  ::|.#######           ..########:|
 .  .  .  ..  .  .. :\ ########          :######## :/
  .        .+ :: : -.:\ ########       . ########.:/
    .  .+   . . . . :.:\. #######       #######..:/
      :: . . . . ::.:..:.\           .   .   ..:/
   .   .   .  .. :  -::::.\.       | |     . .:/
      .  :  .  .  .-:.":.::.\             ..:/
 .      -.   . . . .: .:::.:.\.           .:/
.   .   .  :      : ....::_:..:\   ___.  :/
   .   .  .   .:. .. .  .: :.:.:\       :/
     +   .   .   : . ::. :.:. .:.|\  .:/|
     .         +   .  .  ...:: ..|  --.:|
.      . . .   .  .  . ... :..:.."(  ..)"
 .   .       .      :  .   .: ::/  .  .::\
*/
//
//////////////////////////////////////////
session_start();
$page = "displayImport";
require_once("scripts/inc.connectDB.php");
///////////////////////////////////////
// recup dateImport dans json_troughts
$dbRequest=$connectDB->query("select * from json_thoughts order by idThought asc");
$dbRequest->setFetchMode(PDO::FETCH_OBJ);
$txtOKInDb = "";
if( $getResult = $dbRequest->fetch() ) {
	$dateImportDb = $getResult->dateImport;
}else {
	$txtOKInDb = "Les Tables sont vides ! <a href='importJson.php'>Fill in</a>";
}
////////////////////////////////////////
// fonction qui copie un repertoir
function CopieRep ($orig,$dest) { 
  mkdir ($dest,0755);
  $dir = dir($orig); 
  while ($entry=$dir->read()) { 
    $pathOrig = "$orig/$entry"; 
    $pathDest = "$dest/$entry"; 
    // repertoire ->copie récursive
    if (is_dir($pathOrig) and (substr($entry,0,1)<>'.')) CopieRep ($pathOrig,$pathDest);     
   // fichier -> copie simple
   if (is_file($pathOrig) and ($pathDest<>'') and ($fp=fopen($pathOrig,'rb'))) { 
      $buf = fread($fp,filesize($pathOrig)); 
      $cop = fopen($pathDest,'ab+'); 
      fputs ($cop,$buf); 
      fclose ($cop); 
      fclose ($fp); 
    } 
  } 
  $dir->close(); 
} 
////////////////////////////////////////////
// import all missing thoughts in alpha
if(isset($_GET['uloadAllMissingInAlpha'])) {
	// while import and check if missing insert
	$dbRequest=$connectDB->query("select * from json_thoughts order by CreationDateTime desc");
	$dbRequest->setFetchMode(PDO::FETCH_OBJ);
	while( $getResult = $dbRequest->fetch() ) {// boucle toutes les pensées 
		$idThought = $getResult->idThought;
		$Name = $getResult->Name;
		$ActivationDateTime = $getResult->ActivationDateTime;
		$ACType = $getResult->ACType;
		$Kind = $getResult->Kind;
		$TagIds = $getResult->TagIds;
		$Label = $getResult->Label;
		$ThoughtIconInfo = $getResult->ThoughtIconInfo;
		$CreationDateTime = $getResult->CreationDateTime;
		$ModificationDateTime = $getResult->ModificationDateTime;
		$SyncSentId = $getResult->SyncSentId;
		$BrainId = $getResult->BrainId;
		$idThought = $getResult->Id;
		// check if existe in alpha
		$existe = false;
		$dbRequestExiste=$connectDB->query("select * from alpha_thoughts where Id='$idThought'");
		$dbRequestExiste->setFetchMode(PDO::FETCH_OBJ);
		if( $getResultExiste = $dbRequestExiste->fetch() ) {
			$existe = true;
		}
		if($existe==false) {
			// insert data thoughts in alpha
			$connectDB->exec("insert into alpha_thoughts (active, Name, ActivationDateTime, ACType, Kind, TagIds, Label, ThoughtIconInfo, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('yes', '$Name', '$ActivationDateTime', '$ACType', '$Kind', '$TagIds', '$Label', '$ThoughtIconInfo', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$idThought')");
			// insert parents data links
			$dbRequestParents=$connectDB->query("select * from json_links where ThoughtIdB='$idThought'");
			$dbRequestParents->setFetchMode(PDO::FETCH_OBJ);
			while( $getResultParents = $dbRequestParents->fetch() ) {
				$ThoughtIdA = $getResultParents->ThoughtIdA;
				$ThoughtIdB = $getResultParents->ThoughtIdB;
				$Kind = $getResultParents->Kind;
				$Relation = $getResultParents->Relation;	
				$Direction = $getResultParents->Direction;	
				$Meaning = $getResultParents->Meaning;	
				$Thickness = $getResultParents->Thickness;	
				$CreationDateTime = $getResultParents->CreationDateTime;	
				$ModificationDateTime = $getResultParents->ModificationDateTime;	
				$SyncSentId = $getResultParents->SyncSentId;	
				$BrainId = $getResultParents->BrainId;	
				$Id = $getResultParents->Id;
				// insert in alpha si id du link n'existe pas
				$idLinkExiste = false;
				$dbRequestCheckIfLinkIdExiste=$connectDB->query("select * from alpha_links where Id='$Id'");
				$dbRequestCheckIfLinkIdExiste->setFetchMode(PDO::FETCH_OBJ);
				if( $getResultCheckIfLinkIdExiste = $dbRequestCheckIfLinkIdExiste->fetch() ) {
					$idLinkExiste = true;
				}
				if($idLinkExiste== false) {
					$connectDB->exec("insert into alpha_links (ThoughtIdA, ThoughtIdB, Kind, Relation, Direction, Meaning, Thickness, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$ThoughtIdA', '$ThoughtIdB', '$Kind', '$Relation', '$Direction', '$Meaning', '$Thickness', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$Id')");
				}
			}
			// insert child data links 
			$dbRequestChild=$connectDB->query("select * from json_links where ThoughtIdA='$idThought'");
			$dbRequestChild->setFetchMode(PDO::FETCH_OBJ);
			while( $getResultChild = $dbRequestChild->fetch() ) {
				$ThoughtIdA = $getResultChild->ThoughtIdA;
				$ThoughtIdB = $getResultChild->ThoughtIdB;
				$Kind = $getResultChild->Kind;
				$Relation = $getResultChild->Relation;	
				$Direction = $getResultChild->Direction;	
				$Meaning = $getResultChild->Meaning;	
				$Thickness = $getResultChild->Thickness;	
				$CreationDateTime = $getResultChild->CreationDateTime;	
				$ModificationDateTime = $getResultChild->ModificationDateTime;	
				$SyncSentId = $getResultChild->SyncSentId;	
				$BrainId = $getResultChild->BrainId;	
				$Id = $getResultChild->Id;
				// insert in alpha si id link n'existe pas
				$idLinkExiste = false;
				$dbRequestCheckIfLinkIdExiste=$connectDB->query("select * from alpha_links where Id='$Id'");
				$dbRequestCheckIfLinkIdExiste->setFetchMode(PDO::FETCH_OBJ);
				if( $getResultCheckIfLinkIdExiste = $dbRequestCheckIfLinkIdExiste->fetch() ) {
					$idLinkExiste = true;
				}
				if($idLinkExiste== false) {
					$connectDB->exec("insert into alpha_links (ThoughtIdA, ThoughtIdB, Kind, Relation, Direction, Meaning, Thickness, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$ThoughtIdA', '$ThoughtIdB', '$Kind', '$Relation', '$Direction', '$Meaning', '$Thickness', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$Id')");
				}
			}
			// insert data attachments
			$dbRequestAtt=$connectDB->query("select * from json_attachments where SourceId='$idThought'");
			$dbRequestAtt->setFetchMode(PDO::FETCH_OBJ);
			while( $getResultAtt = $dbRequestAtt->fetch() ) {
				$SourceId = $getResultAtt->SourceId;
				$Name = $getResultAtt->Name;
				$Position = $getResultAtt->Position;
				$FileModificationDateTime = $getResultAtt->FileModificationDateTime;	
				$Type = $getResultAtt->Type;	
				$DataLength = $getResultAtt->DataLength;	
				$Location = $getResultAtt->Location;	
				$IsIcon = $getResultAtt->IsIcon;	
				$SourceType = $getResultAtt->SourceType;	
				$NoteType = $getResultAtt->NoteType;	
				$IsWallpaper = $getResultAtt->IsWallpaper;	
				$IsBrainIcon = $getResultAtt->IsBrainIcon;		
				$IsBrainAttachment = $getResultAtt->IsBrainAttachment;		
				$CreationDateTime = $getResultAtt->CreationDateTime;		
				$ModificationDateTime = $getResultAtt->ModificationDateTime;		
				$SyncSentId = $getResultAtt->SyncSentId;		
				$BrainId = $getResultAtt->BrainId;	
				$Id = $getResultAtt->Id;
				$connectDB->exec("insert into alpha_attachments (SourceId, Name, Position, FileModificationDateTime, Type, DataLength, Location, IsIcon, SourceType, NoteType, IsWallpaper, IsBrainIcon, IsBrainAttachment, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$SourceId', '$Name', '$Position', '$FileModificationDateTime', '$Type', '$DataLength', '$Location', '$IsIcon', '$SourceType', '$NoteType', '$IsWallpaper', '$IsBrainIcon', '$IsBrainAttachment', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$Id')");
			}
			// copy folder root
			$orig = "import_json_thebrain/".$dateImportDb."/".$idThought."";
			$dest = "dataAlpha/".$idThought."";
			// ici je controle si il existe
			if (file_exists($orig)) {
				CopieRep ($orig,$dest);
			}
			$orig = "import_json_thebrain/".$dateImportDb."/".$idThought."/.data";
			$dest = "dataAlpha/".$idThought."/.data";
			// ici je controle si il existe
			if (file_exists($orig)) {
				CopieRep ($orig,$dest);
			}
		}// if existe
	}// while pensee
	header("location:?");
}
/////////////////////////////////////
// import missing thoughts in alpha
if(isset($_GET['uloadInAlpha'])) { // 
	// insert one by one if doesn't existe
	$idThought = $_GET['uloadInAlpha'];
	$dbRequest=$connectDB->query("select * from json_thoughts where Id='$idThought'");
	$dbRequest->setFetchMode(PDO::FETCH_OBJ);
	if( $getResult = $dbRequest->fetch() ) { 
		$Name = $getResult->Name;
		$ActivationDateTime = $getResult->ActivationDateTime;
		$ACType = $getResult->ACType;
		$Kind = $getResult->Kind;
		$TagIds = $getResult->TagIds;
		$Label = $getResult->Label;
		$ThoughtIconInfo = $getResult->ThoughtIconInfo;
		$CreationDateTime = $getResult->CreationDateTime;
		$ModificationDateTime = $getResult->ModificationDateTime;
		$SyncSentId = $getResult->SyncSentId;
		$BrainId = $getResult->BrainId;
		$Id = $getResult->Id; 
		// insert data thoughts in alpha
		$connectDB->exec("insert into alpha_thoughts (active, Name, ActivationDateTime, ACType, Kind, TagIds, Label, ThoughtIconInfo, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('yes', '$Name', '$ActivationDateTime', '$ACType', '$Kind', '$TagIds', '$Label', '$ThoughtIconInfo', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$Id')");
		// insert parents data links
		$dbRequestParents=$connectDB->query("select * from json_links where ThoughtIdB='$idThought'");
		$dbRequestParents->setFetchMode(PDO::FETCH_OBJ);
		while( $getResultParents = $dbRequestParents->fetch() ) { 
			$ThoughtIdA = $getResultParents->ThoughtIdA;
			$ThoughtIdB = $getResultParents->ThoughtIdB;
			$Kind = $getResultParents->Kind;
			$Relation = $getResultParents->Relation;	
			$Direction = $getResultParents->Direction;	
			$Meaning = $getResultParents->Meaning;	
			$Thickness = $getResultParents->Thickness;	
			$CreationDateTime = $getResultParents->CreationDateTime;	
			$ModificationDateTime = $getResultParents->ModificationDateTime;	
			$SyncSentId = $getResultParents->SyncSentId;	
			$BrainId = $getResultParents->BrainId;	
			$Id = $getResultParents->Id;
			// insert in alpha si id n'existe pas
			$idLinkExiste = false;
			$dbRequestCheckIfLinkIdExiste=$connectDB->query("select * from alpha_links where Id='$Id'");
			$dbRequestCheckIfLinkIdExiste->setFetchMode(PDO::FETCH_OBJ);
			if( $getResultCheckIfLinkIdExiste = $dbRequestCheckIfLinkIdExiste->fetch() ) {
				$idLinkExiste = true;
			}
			if($idLinkExiste== false) {
				$connectDB->exec("insert into alpha_links (ThoughtIdA, ThoughtIdB, Kind, Relation, Direction, Meaning, Thickness, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$ThoughtIdA', '$ThoughtIdB', '$Kind', '$Relation', '$Direction', '$Meaning', '$Thickness', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$Id')");
			}
		}
		// insert child data links 
		$dbRequestChild=$connectDB->query("select * from json_links where ThoughtIdA='$idThought'");
		$dbRequestChild->setFetchMode(PDO::FETCH_OBJ);
		while( $getResultChild = $dbRequestChild->fetch() ) {
			$ThoughtIdA = $getResultChild->ThoughtIdA;
			$ThoughtIdB = $getResultChild->ThoughtIdB;
			$Kind = $getResultChild->Kind;
			$Relation = $getResultChild->Relation;	
			$Direction = $getResultChild->Direction;	
			$Meaning = $getResultChild->Meaning;	
			$Thickness = $getResultChild->Thickness;	
			$CreationDateTime = $getResultChild->CreationDateTime;	
			$ModificationDateTime = $getResultChild->ModificationDateTime;	
			$SyncSentId = $getResultChild->SyncSentId;	
			$BrainId = $getResultChild->BrainId;	
			$Id = $getResultChild->Id;
			// insert in alpha si id n'existe pas
			$idLinkExiste = false;
			$dbRequestCheckIfLinkIdExiste=$connectDB->query("select * from alpha_links where Id='$Id'");
			$dbRequestCheckIfLinkIdExiste->setFetchMode(PDO::FETCH_OBJ);
			if( $getResultCheckIfLinkIdExiste = $dbRequestCheckIfLinkIdExiste->fetch() ) {
				$idLinkExiste = true;
			}
			if($idLinkExiste== false) {
				$connectDB->exec("insert into alpha_links (ThoughtIdA, ThoughtIdB, Kind, Relation, Direction, Meaning, Thickness, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$ThoughtIdA', '$ThoughtIdB', '$Kind', '$Relation', '$Direction', '$Meaning', '$Thickness', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$Id')");
			}
		}
		// insert data attachments
		$dbRequestAtt=$connectDB->query("select * from json_attachments where SourceId='$idThought'");
		$dbRequestAtt->setFetchMode(PDO::FETCH_OBJ);
		while( $getResultAtt = $dbRequestAtt->fetch() ) { 
			$SourceId = $getResultAtt->SourceId;
			$Name = $getResultAtt->Name;
			$Position = $getResultAtt->Position;
			$FileModificationDateTime = $getResultAtt->FileModificationDateTime;	
			$Type = $getResultAtt->Type;	
			$DataLength = $getResultAtt->DataLength;	
			$Location = $getResultAtt->Location;	
			$IsIcon = $getResultAtt->IsIcon;	
			$SourceType = $getResultAtt->SourceType;	
			$NoteType = $getResultAtt->NoteType;	
			$IsWallpaper = $getResultAtt->IsWallpaper;	
			$IsBrainIcon = $getResultAtt->IsBrainIcon;		
			$IsBrainAttachment = $getResultAtt->IsBrainAttachment;		
			$CreationDateTime = $getResultAtt->CreationDateTime;		
			$ModificationDateTime = $getResultAtt->ModificationDateTime;		
			$SyncSentId = $getResultAtt->SyncSentId;		
			$BrainId = $getResultAtt->BrainId;	
			$Id = $getResultAtt->Id;
			$connectDB->exec("insert into alpha_attachments (SourceId, Name, Position, FileModificationDateTime, Type, DataLength, Location, IsIcon, SourceType, NoteType, IsWallpaper, IsBrainIcon, IsBrainAttachment, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$SourceId', '$Name', '$Position', '$FileModificationDateTime', '$Type', '$DataLength', '$Location', '$IsIcon', '$SourceType', '$NoteType', '$IsWallpaper', '$IsBrainIcon', '$IsBrainAttachment', '$CreationDateTime', '$ModificationDateTime', '$SyncSentId', '$BrainId', '$Id')");
		}
		// copy folder root
		$orig = "import_json_thebrain/".$dateImportDb."/".$idThought."";
		$dest = "dataAlpha/".$idThought."";
		// ici je controle si il existe
		if (file_exists($orig)) {
			CopieRep ($orig,$dest);
		}
		$orig = "import_json_thebrain/".$dateImportDb."/".$idThought."/.data";
		$dest = "dataAlpha/".$idThought."/.data";
		// ici je controle si il existe
		if (file_exists($orig)) {
			CopieRep ($orig,$dest);
		}
	}
	header("location:?");
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Get Data from The Brain</title>
	<?php require_once("scripts/inc.head.php");?>
</head>
<body>
	<div class="container_"><br>
		<h3>Get Data from The Brain</h3>
		<?php require_once("scripts/inc.nav.php");?><br>
		<div class="table-responsive">
			<h5>Display Import Data from DB</h5>
			Date de l'import : <b><?php echo($dateImportDb."".$txtOKInDb);// date de l'import?></b><br><br>
			<a href="?uloadAllMissingInAlpha=<?php echo($Id);?>" title="upload in the alpha database"><img src="img/upload.png" width="64" height="64" alt=""/></a> Import all missing thoughts in the Alpha DB<br><br>
			<table id="table_displayImport" class="display">
				<thead>
					<tr>
						<th>Action</th>
						<th>Parents</th>
						<th>Name/Label</th>
						<th>Icone</th>
						<th>Note</th>
						<th>Attachments</th>
						<th>Children</th>
						<th>Date</th>
						<th>Id</th>
					</tr>
				</thead>
				<tbody>
					<?php // liste toutes les pensée importées
					$dbRequest=$connectDB->query("select * from json_thoughts where Kind='1' order by CreationDateTime desc");
					$dbRequest->setFetchMode(PDO::FETCH_OBJ);
					while( $getResult = $dbRequest->fetch() ) {
						$Name = $getResult->Name;
						$ActivationDateTime = $getResult->ActivationDateTime;
						$ACType = $getResult->ACType;
						$Kind = $getResult->Kind;
						$TagIds = $getResult->TagIds;
						$Label = $getResult->Label;
						$ThoughtIconInfo = $getResult->ThoughtIconInfo;
						$CreationDateTime = $getResult->CreationDateTime;
						$ModificationDateTime = $getResult->ModificationDateTime;
						$SyncSentId = $getResult->SyncSentId;
						$BrainId = $getResult->BrainId;
						$Id = $getResult->Id;
						// extract date, format dans la base (2020-04-08T11:28:23.682087)
						$dateJJ = substr($ModificationDateTime, 8, 2);     // jour  
						$dateMM = substr($ModificationDateTime, 5, 2);    // mois 
						$dateAAAA = substr($ModificationDateTime, 0, 4); // annee
						$ModificationDateDisplay = $dateJJ."-".$dateMM."-".$dateAAAA;
						// extract time
						$timeHours = substr($ModificationDateTime, 11, 2);
						$timeMinutes = substr($ModificationDateTime, 14, 2);
						$timeSeconds = substr($ModificationDateTime, 17, 2);
						$ModificationTimeDisplay = $timeHours.":".$timeMinutes.":".$timeSeconds;
						// test si la thought a un parent
						$dbRequestIfExisteParents=$connectDB->query("select * from json_links where ThoughtIdB='$Id' and Meaning='1'"); 
						$dbRequestIfExisteParents->setFetchMode(PDO::FETCH_OBJ);
						if( $getResultIfExisteParents = $dbRequestIfExisteParents->fetch() ) {
							// il existe un lien parent alors je boucle
					?>
					<tr>
						<td style="font-size: 10px;">
						    <?php // test si il existe deja dans la base alpha
							$existe = false;
							$dbRequestExiste=$connectDB->query("select * from alpha_thoughts where Id='$Id'");
							$dbRequestExiste->setFetchMode(PDO::FETCH_OBJ);
							if( $getResultExiste = $dbRequestExiste->fetch() ) {
								$ModificationDateTimeAlpha = $getResultExiste->ModificationDateTime;
								// extract date, format dans la base (2020-04-08T11:28:23.682087)
								$dateJJ = substr($ModificationDateTimeAlpha, 8, 2);     // jour  
								$dateMM = substr($ModificationDateTimeAlpha, 5, 2);    // mois 
								$dateAAAA = substr($ModificationDateTimeAlpha, 0, 4); // annee
								$ModificationDateAlphaDisplay = $dateJJ."-".$dateMM."-".$dateAAAA;
								// extract time
								$timeHours = substr($ModificationDateTimeAlpha, 11, 2);
								$timeMinutes = substr($ModificationDateTimeAlpha, 14, 2);
								$timeSeconds = substr($ModificationDateTimeAlpha, 17, 2);
								$ModificationTimeAlphaDisplay = $timeHours.":".$timeMinutes.":".$timeSeconds;
								$existe = true;
							}
							if($existe==false) {
							?>
							<a href="?uloadInAlpha=<?php echo($Id);?>" title="upload in the alpha database"><img src="img/upload.png" width="44" height="44" alt=""/></a><br>Missing!<br>
							<?php }else {?>
							<i class="far fa-check-circle fa-2x green" title="Item already in the alpha db"></i><br>
							<u>Last Modif. Alpha</u><br><?php echo($ModificationDateAlphaDisplay);?>/<?php echo($ModificationTimeAlphaDisplay);?>
							<?php }?>
							<u>Last Modif. Json</u><br><?php echo($ModificationDateDisplay);?>/<?php echo($ModificationTimeDisplay);?>
						</td>
						<td style="font-size: 10px;">
							<?php // ici je vais chercher si il a des parents
							$dbRequestParents=$connectDB->query("select * from json_links where ThoughtIdB='$Id' and Meaning='1'"); 
							$dbRequestParents->setFetchMode(PDO::FETCH_OBJ);
							while( $getResultParents = $dbRequestParents->fetch() ) {
								$idParent = $getResultParents->ThoughtIdA;
								// recup le nom du child
								$dbRequestCN=$connectDB->query("select * from json_thoughts where Id='$idParent'"); // 5 = icone / 1 = notes / 3 = link
								$dbRequestCN->setFetchMode(PDO::FETCH_OBJ);
								if( $getResultCN = $dbRequestCN->fetch() ) {
									$ParentName = $getResultCN->Name; 
									echo($ParentName.", ");
								}
							}?>
						</td>
						<td><b><?php echo($Name);?></b><br><?php echo($Label);?></td>
						<td>
							<?php // ici je vais chercher l'icone
							$dbRequestIP=$connectDB->query("select * from json_attachments where SourceId='$Id' and Type='5'"); // 5 = icone / 1 = notes / 3 = link
							$dbRequestIP->setFetchMode(PDO::FETCH_OBJ);
							if( $getResultIP = $dbRequestIP->fetch() ) {
								$LocationIcone = $getResultIP->Location; 
							?>
							<img src="import_json_thebrain/<?php echo($dateImportDb);// date de l'import?>/<?php echo($Id);// dossier de la pensée?>/.data/<?php echo($LocationIcone);?>" width="120" alt=""/>
							<?php }?>
						</td>
						<td style="font-size: 11px;">
							<?php // ici je vais chercher la note
							$dbRequestMD=$connectDB->query("select * from json_attachments where SourceId='$Id' and Type='1'"); // 5 = icone / 1 = notes / 3 = link
							$dbRequestMD->setFetchMode(PDO::FETCH_OBJ);
							if( $getResultMD = $dbRequestMD->fetch() ) {
								$LocationNote = $getResultMD->Location; // import_json_thebrain/<?php echo($dateImportDb);// date de l'import/
								if ($fh = fopen('import_json_thebrain/'.$dateImportDb.'/'.$Id.'/'.$LocationNote, 'r')) {
									while (!feof($fh)) {
										$line = fgets($fh);
										echo $line;
									}
									fclose($fh);
								}
							}?>
						</td>
						<td>
							<?php // ici je vais chercher les urls
							$dbRequestURL=$connectDB->query("select * from json_attachments where SourceId='$Id' and Type='3'"); // 5 = icone / 1 = notes / 3 = link
							$dbRequestURL->setFetchMode(PDO::FETCH_OBJ);
							while( $getResultURL = $dbRequestURL->fetch() ) {
								$NameUrl = $getResultURL->Name;
								$LocationUrl = $getResultURL->Location; 
							?>
							<a href="<?php echo($LocationUrl);?>" target="_blank"><?php echo($NameUrl);?></a><br>
							<?php }?>
						</td>
						<td style="font-size: 10px;">
							<?php // ici je vais chercher si il a des enfants
							$dbRequestChild=$connectDB->query("select * from json_links where ThoughtIdA='$Id' and Meaning='1'"); 
							$dbRequestChild->setFetchMode(PDO::FETCH_OBJ);
							while( $getResultChild = $dbRequestChild->fetch() ) {
								$idChild = $getResultChild->ThoughtIdB;
								// recup le nom du child
								$dbRequestCN=$connectDB->query("select * from json_thoughts where Id='$idChild'"); // 5 = icone / 1 = notes / 3 = link
								$dbRequestCN->setFetchMode(PDO::FETCH_OBJ);
								if( $getResultCN = $dbRequestCN->fetch() ) {
									$childName = $getResultCN->Name;
									echo($childName.", ");
								}
							}?>
						</td>
						<td><?php echo($CreationDateTime);?></td>
						<td style="font-size: 10px;"><?php echo($Id);?></td>
					</tr>
					<?php }
						}?>
				</tbody>
			</table><br><br>
			<hr>
		</div>
	</div>
	<!-- Optional JavaScript -->
    <?php require_once("scripts/inc.framework.php");?>
</body>
</html>