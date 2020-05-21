<?php
///////////////////////////////////////////
///////////////////////////////////////////
/////// Modular Project The Brain /////////
///////////////////////////////////////////
///////////////////////////////////////////
// Title: Home
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
$page = "home";
require_once("scripts/inc.connectDB.php");
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
			<h5>Display Data</h5>
			<table id="table_alphaThoughts" class="display">
				<thead>
					<tr>
						<th>Action</th>
						<th>Type</th>
						<th>Tags</th>
						<th>Parents</th>
						<th>Name/Label</th>
						<th>Children</th>
						<th>Icone</th>
						<th>Note</th>
						<th>Attachments</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php // liste les pensées alpha
					$dbRequest=$connectDB->query("select * from alpha_thoughts where Kind='1' order by CreationDateTime desc");
					$dbRequest->setFetchMode(PDO::FETCH_OBJ);
					while( $getResult = $dbRequest->fetch() ) {
						$active = $getResult->active;
						$type = $getResult->type;
						$categorie = $getResult->categorie;
						$tags = $getResult->tags;
						
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
						
						// ici format la date pour l'affichage, format dans la base (AAAA/MM/JJ)
						$dateJJ = substr($CreationDateTime, 8, 2);     // jour  
						$dateMM = substr($CreationDateTime, 5, 2);    // mois 
						$dateAAAA = substr($CreationDateTime, 0, 4); // annee
						$CreationDateTimeAffichage = $dateJJ."-".$dateMM."-".$dateAAAA;

						// test si la thought a un parent
						$dbRequestIfExisteParents=$connectDB->query("select * from alpha_links where ThoughtIdB='$idThought' and Meaning='1'"); 
						$dbRequestIfExisteParents->setFetchMode(PDO::FETCH_OBJ);
						if( $getResultIfExisteParents = $dbRequestIfExisteParents->fetch() ) {
							// il existe un lien parent alors je boucle
					?>
					<tr>
						<td style="font-size: 10px;">
							
					    	<img src="img/show.png" width="24" height="24" alt=""/>
							
							<img src="img/edit.png" width="24" height="24" alt=""/>
							
							<img src="img/pdf.png" width="24" height="24" alt=""/>
							
							<img src="img/supp.png" width="12" height="12" alt=""/>
							
							<br><br>
							<?php if($active=="yes") { 
								echo("<span style='color:green'>Is Online in Thebrain</span>");
							}else {
								echo("<span style='color:orange'>Local</span>");
							}?>
						</td>
						
						<td style="font-size: 12px;"></td>
						<td><?php echo($idThought_);?></td>
						<td style="font-size: 10px;">
							<?php // ici je vais chercher si il a des parents
							$dbRequestChild=$connectDB->query("select * from alpha_links where ThoughtIdB='$idThought' and Meaning='1'"); 
							$dbRequestChild->setFetchMode(PDO::FETCH_OBJ);
							while( $getResultChild = $dbRequestChild->fetch() ) {
								$idChild = $getResultChild->ThoughtIdA;
								// recup le nom du child
								$dbRequestCN=$connectDB->query("select * from alpha_thoughts where Id='$idChild'"); // 5 = icone / 1 = notes / 3 = link
								$dbRequestCN->setFetchMode(PDO::FETCH_OBJ);
								while( $getResultCN = $dbRequestCN->fetch() ) {
									$childName = $getResultCN->Name;
									echo($childName.", ");
								}
							}?>
						</td>
						<td><b><?php echo($Name);?></b><br><?php echo($Label);?></td>
						<td style="font-size: 10px;">
							<?php // ici je vais chercher si il a des enfants
							$dbRequestChild=$connectDB->query("select * from alpha_links where ThoughtIdA='$idThought' and Meaning='1'"); 
							$dbRequestChild->setFetchMode(PDO::FETCH_OBJ);
							while( $getResultChild = $dbRequestChild->fetch() ) {
								$idChild = $getResultChild->ThoughtIdB;
								// recup le nom du child
								$dbRequestCN=$connectDB->query("select * from alpha_thoughts where Id='$idChild'"); // 5 = icone / 1 = notes / 3 = link
								$dbRequestCN->setFetchMode(PDO::FETCH_OBJ);
								while( $getResultCN = $dbRequestCN->fetch() ) {
									$childName = $getResultCN->Name; 
									echo($childName.", ");
								}
							}?>
						</td>
						<td>
							<?php // ici je vais chercher l'icone
							$dbRequestIP=$connectDB->query("select * from alpha_attachments where SourceId='$idThought' and Type='5'"); // 5 = icone / 1 = notes / 3 = link
							$dbRequestIP->setFetchMode(PDO::FETCH_OBJ);
							if( $getResultIP = $dbRequestIP->fetch() ) {
								$LocationIcone = $getResultIP->Location; 
							?>
							<img src="dataAlpha/<?php echo($idThought);// dossier de la pensée?>/.data/<?php echo($LocationIcone);?>" width="120" alt=""/>
							<?php }?>
						</td>
						<td style="font-size: 11px;">
							<?php // ici je vais chercher la note
							$dbRequestMD=$connectDB->query("select * from alpha_attachments where SourceId='$idThought' and Type='1'"); // 5 = icone / 1 = notes / 3 = link
							$dbRequestMD->setFetchMode(PDO::FETCH_OBJ);
							if( $getResultMD = $dbRequestMD->fetch() ) {
								$LocationNote = $getResultMD->Location; 
							
								if ($fh = fopen('dataAlpha/'.$idThought.'/'.$LocationNote, 'r')) {
									while (!feof($fh)) {
										$line = fgets($fh);
										echo $line;
									}
									fclose($fh);
								}
							}?>
						</td>
						<td style="font-size: 10px;">
							<?php // ici je vais chercher les urls
							$dbRequestURL=$connectDB->query("select * from alpha_attachments where SourceId='$idThought' and Type='3'"); // 5 = icone / 1 = notes / 3 = link
							$dbRequestURL->setFetchMode(PDO::FETCH_OBJ);
							while( $getResultURL = $dbRequestURL->fetch() ) {
								$NameUrl = $getResultURL->Name;
								$LocationUrl = $getResultURL->Location; 
							?>
							<a href="<?php echo($LocationUrl);?>" target="_blank"><?php echo($NameUrl);?></a><br>
							<?php }?>
						</td>
						<td><?php echo($CreationDateTime);?></td>
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