<?php
///////////////////////////////////////////
///////////////////////////////////////////
/////// Modular Project The Brain /////////
///////////////////////////////////////////
///////////////////////////////////////////
// Title: Import Json
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
$page = "importJson";
require_once("scripts/inc.connectDB.php");
require_once("scripts/inc.php_file_tree.php");
if(isset($_SESSION['defineWhichBackupDate'])) {
	$defineWhichBackupDate = $_SESSION['defineWhichBackupDate'];
}
// create new folder
if(isset($_POST['rec_newFolder'])) {
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	$folder = $day."-".$month."-".$year;
	if(($day!="") && ($month!="") && ($year!="")) {
		// creer un dossier , 755 
		mkdir ("import_json_thebrain/$folder");
		chmod ("import_json_thebrain/$folder", 0755);
		header("location:?");
	}
}
?>
<?php
/////////////////////////////////////////////////
/////////////////////////////////////////////////
// insert db thoughts
if(isset($_GET['insertDb'])) {
	// vide les tables
	$connectDB->exec("TRUNCATE TABLE json_thoughts");
	$connectDB->exec("TRUNCATE TABLE json_links");
	$connectDB->exec("TRUNCATE TABLE json_attachments");
	
	// insert db thoughts
	$myJson = file_get_contents("import_json_thebrain/".$defineWhichBackupDate."/re_thoughts.json", true);
	$myJson = json_decode($myJson);
	foreach($myJson as $row) 
	{
		// TagIds est un array ??????
		$connectDB->exec("insert into json_thoughts (Name, dateImport, ActivationDateTime, ACType, Kind, TagIds, Label, ThoughtIconInfo, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$row->Name', '$defineWhichBackupDate', '$row->ActivationDateTime', '$row->ACType', '$row->Kind', '$row->TagIds', '$row->Label', '$row->ThoughtIconInfo', '$row->CreationDateTime', '$row->ModificationDateTime', '$row->SyncSentId', '$row->BrainId', '$row->Id')");
	}
	// insert db links
	$myJson = file_get_contents("import_json_thebrain/".$defineWhichBackupDate."/re_links.json", true);
	$myJson = json_decode($myJson);
	foreach($myJson as $row) 
	{
		$connectDB->exec("insert into json_links (ThoughtIdA, ThoughtIdB, Kind, Relation, Direction, Meaning, Thickness, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$row->ThoughtIdA', '$row->ThoughtIdB', '$row->Kind', '$row->Relation', '$row->Direction', '$row->Meaning', '$row->Thickness', '$row->CreationDateTime', '$row->ModificationDateTime', '$row->SyncSentId', '$row->BrainId', '$row->Id')");
	}
	// insert db attachments
	$myJson = file_get_contents("import_json_thebrain/".$defineWhichBackupDate."/re_attachments.json", true);
	$myJson = json_decode($myJson);
	foreach($myJson as $row) 
	{
		$connectDB->exec("insert into json_attachments (SourceId, Name, Position, FileModificationDateTime, Type, DataLength, Location, IsIcon, SourceType, NoteType, IsWallpaper, IsBrainIcon, IsBrainAttachment, CreationDateTime, ModificationDateTime, SyncSentId, BrainId, Id) value ('$row->SourceId', '$row->Name', '$row->Position', '$row->FileModificationDateTime', '$row->Type', '$row->DataLength', '$row->Location', '$row->IsIcon', '$row->SourceType', '$row->NoteType', '$row->IsWallpaper', '$row->IsBrainIcon', '$row->IsBrainAttachment', '$row->CreationDateTime', '$row->ModificationDateTime', '$row->SyncSentId', '$row->BrainId', '$row->Id')");
	}
	header("location:displayImport.php");
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
			<h5>Import from The Brain Export</h5>
			Dans le dossier /import_json_thebrain/, créer un sous dossier en le noment avec la date,<br>
			puis importer l'export en Json thebrain avec tout les dossiers dedans, avec le finder ou l'exploreur sous windows, en ligne avec <a href="https://filezilla-project.org/" target="_blank">Filezilla</a><br>Cela crée un premier backup de l'organigramme<br><br>
			<form action="?" method="post">
			<select tabindex="1" class="form-control m-b-10 input-sm" name="day" id="day" style="width: 80px; display: inline-block">
				<option value="">Day</option>
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select>
			-
			<select tabindex="1" class="form-control m-b-10 input-sm" name="month" id="month" style="width: 80px; display: inline-block">
				<option value="">Month</option>
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
			</select>
			-
			<select tabindex="1" class="form-control m-b-10 input-sm" name="year" id="year" style="width: 80px; display: inline-block">
				<option value="">Year</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
			</select>
			<button type="submit" name="rec_newFolder" class="btn btn-primary active">Create new folder</button><br>
				(optionel si pas déjà créer)
			</form>
			<br>
			<span>Content Root of import folder, Path: <b>/import_json_thebrain/</b></span>
			<div class="bgBox_" id="fileTree" style="color: white;">
			<?php
			echo php_file_tree("import_json_thebrain/", "javascript:return;");// [link]
			?>
			</div>
			<br><hr><br>
			Modification des fichiers !<br>
			1. copier les trois fichiers re_attachments.json, re_links.json et re_thoughts.json dans le dossier en question ils serviront à l'extraction des données.<br><br>
			Info les fichiers peuvent être modifiers et enregistrer avec un simple editeur de texte !<br><br>
			2. ouvrir le fichier thoughts.json original et copier son contenu dans le fichier re_thoughts.json<br>
			pareil pour les fichiers links.json et attachments.json copier et collé leurs contenu dans les fichiers re_links.json et re_attachments.json<br><br>
			3. dans les trois fichiers re_ ajouter au debut du code "<span style="color:red;">[</span>" et "<span style="color:red;">]</span>" à la fin.<br><br>
			4. puis ajouter des virugles après chaque objet {objet} devient {objet}<span style="color:red;">,</span> (cela peut se faire rapidement avec la fonction recherche et remplace "recherche } et remplace par },")<br>
			ATTENTION pas à la dernière entrée, sinon le bot pensera que la liste n'est pas finie et sa plante !<br><br>
			Voici à quoi cela devrait ressembler<br><br>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6" style="overflow: hidden;">
						Original non modifier<br>
						{"Name":"Skydiving","ActivationDateTime":"2020-04-08T11:20:43.682022","ACType":0,"Kind":1,"TagIds":[],"ThoughtIconInfo":"7::1:True:False:0","CreationDateTime":"2020-04-06T17:32:44.615837","ModificationDateTime":"2020-04-07T10:16:47.894773","SyncSentId":"be081ebb-37e1-4034-9ee4-54cf1fcbec1f","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"1a56cdcb-2dfa-431b-b664-42dcaf79451c"},<br>
						{"Name":"Loisirs","ActivationDateTime":"2020-04-08T11:23:03.220098","ACType":0,"Kind":1,"TagIds":[],"ThoughtIconInfo":"1::0:True:False:0","CreationDateTime":"2020-04-08T10:04:18.349452","ModificationDateTime":"2020-04-08T10:56:15.162559","SyncSentId":"814c4f11-55b6-4b44-9a93-452ec2159d27","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"1ce04dec-6fe0-4aaf-a603-a886cf326d48"}<br>
						...<br>
						{"Name":"Moto","ActivationDateTime":"2020-04-08T11:20:33.590221","ACType":0,"Kind":1,"TagIds":[],"Label":"xx blackbird 1100","ThoughtIconInfo":"7::0:True:False:0","CreationDateTime":"2020-04-08T10:18:03.422432","ModificationDateTime":"2020-04-08T10:57:01.951056","SyncSentId":"814c4f11-55b6-4b44-9a93-452ec2159d27","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"f3b37f86-192b-488d-b768-337d54465538"}<br>
						{"Name":"Sports","ActivationDateTime":"2020-04-08T11:20:40.945671","ACType":0,"Kind":1,"TagIds":[],"ThoughtIconInfo":"7::0:False:False:0","CreationDateTime":"2020-04-06T17:30:05.390176","ModificationDateTime":"2020-04-08T10:48:04.880953","SyncSentId":"a3248b98-8c80-4cd2-a0b9-4d1bbcacec67","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"f6b93b39-4fa3-4521-8ed4-2c9987e91527"}
					</div>
					<div class="col-md-6">
						Fichier après modification<br>
						<span style="color:red;">[</span>{"Name":"Skydiving","ActivationDateTime":"2020-04-08T11:20:43.682022","ACType":0,"Kind":1,"TagIds":[],"ThoughtIconInfo":"7::1:True:False:0","CreationDateTime":"2020-04-06T17:32:44.615837","ModificationDateTime":"2020-04-07T10:16:47.894773","SyncSentId":"be081ebb-37e1-4034-9ee4-54cf1fcbec1f","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"1a56cdcb-2dfa-431b-b664-42dcaf79451c"}<span style="color:red;">,</span><br>
						{"Name":"Loisirs","ActivationDateTime":"2020-04-08T11:23:03.220098","ACType":0,"Kind":1,"TagIds":[],"ThoughtIconInfo":"1::0:True:False:0","CreationDateTime":"2020-04-08T10:04:18.349452","ModificationDateTime":"2020-04-08T10:56:15.162559","SyncSentId":"814c4f11-55b6-4b44-9a93-452ec2159d27","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"1ce04dec-6fe0-4aaf-a603-a886cf326d48"}<span style="color:red;">,</span><br>
						...<br>
						{"Name":"Moto","ActivationDateTime":"2020-04-08T11:20:33.590221","ACType":0,"Kind":1,"TagIds":[],"Label":"xx blackbird 1100","ThoughtIconInfo":"7::0:True:False:0","CreationDateTime":"2020-04-08T10:18:03.422432","ModificationDateTime":"2020-04-08T10:57:01.951056","SyncSentId":"814c4f11-55b6-4b44-9a93-452ec2159d27","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"f3b37f86-192b-488d-b768-337d54465538"}<span style="color:red;">,</span><br>
						{"Name":"Sports","ActivationDateTime":"2020-04-08T11:20:40.945671","ACType":0,"Kind":1,"TagIds":[],"ThoughtIconInfo":"7::0:False:False:0","CreationDateTime":"2020-04-06T17:30:05.390176","ModificationDateTime":"2020-04-08T10:48:04.880953","SyncSentId":"a3248b98-8c80-4cd2-a0b9-4d1bbcacec67","BrainId":"e54df3d4-d537-4e8e-88b4-ff6afdc2119a","Id":"f6b93b39-4fa3-4521-8ed4-2c9987e91527"}<span style="color:green;">(ne pas mettre de virgule ici)</span><span style="color:red;">]</span>
					</div>
				</div>
			</div>
			<br>
			ci-dessous le code vas lire les fichiers modifier!
			<br><hr><br>
			Well done, les fichiers sont sauvegarder et prêt à être utilisés<br>
			Maintenant il faut definir sur quel backup nous voulons travailler ?<br><br>
			Choisir le backup de travail<br>
			<select tabindex="1" class="form-control m-b-10 input-sm" onChange="defineWhichBackup();" name="defineWhichBackup" id="defineWhichBackup" style="width: 180px; display: inline-block">
			<?php if(isset($_SESSION['defineWhichBackupDate'])) {?>
				<option value="<?php echo($defineWhichBackupDate);?>"><?php echo($defineWhichBackupDate);?></option>	
			<?php }?>
				<option value=""></option>
			<?php
			  	$liste_rep = scandir("import_json_thebrain/");  //       A REMPLIR !!!
				$i = 0;
				$num = count($liste_rep);
				while($i < $num){
					if(($liste_rep[$i]!=".") && ($liste_rep[$i]!="..") && ($liste_rep[$i]!="re_attachments.json") && ($liste_rep[$i]!="re_links.json") && ($liste_rep[$i]!="re_thoughts.json")) {
					echo "<a href='?defineBackup=".$liste_rep[$i]."'>$liste_rep[$i]</a><br />";?>
					<option value="<?php echo($liste_rep[$i]);?>"><?php echo($liste_rep[$i]);?></option>
					<?php }
					$i++;
				}
			?>
			</select>
			<br><br>
			Test de lecture des fichier après modifications<br>
			Path and Date of import: <b>/import_json_thebrain/<?php echo($defineWhichBackupDate);// date de l'import?></b><br>
			Ici je liste seulement 10 résultat et les deux premières valeur pour être sûr que les fichiers .json sont lu :)
			<table class="table table-bordered">
				<tr>
					<th>My Data Thought file re_thoughts.json</th>
				</tr>
				<?php 
				$okThoughts = true;
				$myJson = file_get_contents("import_json_thebrain/".$defineWhichBackupDate."/re_thoughts.json", true);
				$myJson = json_decode($myJson);
				if(!$myJson) {
					echo '<tr><td><span style="color: red;"><b>Fichier non lisible ou inexistant</b></span</td></tr>';
					$okThoughts = false;
				}
				$i=0;
				foreach($myJson as $row) 
				{
					if($i<=10) {
					echo '<tr><td>Name: <b>'.$row->Name.'</b> - ModificationDateTime: <b>'.$row->ModificationDateTime.'</b></td></tr>';
					}
					$i++;
				}
				?>
			</table>
			<table class="table table-bordered">
				<tr>
					<th>My Data Links file re_links.json</th>
				</tr>
				<?php 
				$okLinks = true;
				$myJson = file_get_contents("import_json_thebrain/".$defineWhichBackupDate."/re_links.json", true);
				$myJson = json_decode($myJson);
				if(!$myJson) {
					echo '<tr><td><span style="color: red;"><b>Fichier non lisible ou inexistant</b></span</td></tr>';
					$okLinks = false;
				}
				$i=0;
				foreach($myJson as $row) 
				{
					if($i<=10) {
					echo '<tr><td>ID A: <b>'.$row->ThoughtIdA.'</b> - ID B: <b>'.$row->ThoughtIdB.'</b></td></tr>';
					}
					$i++;
				}
				?>
			</table>
			<table class="table table-bordered">
				<tr>
					<th>My Data Attachments file re_attachments.json</th>
				</tr>
				<?php 
				$okAttachments = true;
				$myJson = file_get_contents("import_json_thebrain/".$defineWhichBackupDate."/re_attachments.json", true);
				$myJson = json_decode($myJson);
				if(!$myJson) {
					echo '<tr><td><span style="color: red;"><b>Fichier non lisible ou inexistant</b></span</td></tr>';
					$okAttachments = false;
				}
				$i=0;
				foreach($myJson as $row) 
				{	
					if($i<=10) {
					echo '<tr><td>SourceId: <b>'.$row->SourceId.'</b> - ID B: <b>'.$row->Name.'</b></td></tr>';
					}
					$i++;
				}
				?>
			</table>
			<hr>
			<br><br>
			<?php if(isset($_SESSION['defineWhichBackupDate'])) {
					if(($okThoughts==true) && ($okLinks==true) && ($okAttachments==true)) {?>
			Perfect! si les trois fichiers ci-dessus affichent des infos on est bon<br>
			Maintenant nous pouvons inserer dans la base de donnée les inforamtions !
			<br><br>
			<a href="?insertDb=1"><button type="button" class="btn btn-primary btn-block">Insert <?php echo($defineWhichBackupDate);?> Data in the DB</button></a><br><br>
			<?php } 
			}?>
		</div>
	<!-- Optional JavaScript -->
    <?php require_once("scripts/inc.framework.php");?>
</body>
</html>