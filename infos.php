<?php
///////////////////////////////////////////
///////////////////////////////////////////
/////// Modular Project The Brain /////////
///////////////////////////////////////////
///////////////////////////////////////////
// Title: Infos
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
$page = "infos";
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
			<h5>Welcome</h5><br>
			Ceci est une petit application qui récupère les informations des fichiers Json d'un organigramme Thebrain !<br>
			afin de pourvoir les sauvegarder et de les exploités, cette appplication fonctionne en local comme en ligne.<br><br>
			Installation<br>
			Pour commencer il vous faut créer une base de donnée en ligne sur votre hébérgeur ou en local<br>
			Pour une install en local il faudra un environement de travail (Apache2, MySQL, PHP) pour Mac <a href="https://www.mamp.info/en/downloads/" target="_blank">MAMP</a> ou <a href="https://sourceforge.net/projects/wampserver/" target="_blank">WAMP</a> pour Windows ou LAMP sous Linux<br><br>
			
			installer les tables qui recup les infos des Json<br>
			<a href="sql/json_thoughts.sql"><i class="fas fa-pager"></i> json_thoughts.sql</a><br>
			<a href="sql/json_links.sql"><i class="fas fa-pager"></i> json_links.sql</a><br>
			<a href="sql/json_attachments.sql"><i class="fas fa-pager"></i> json_attachments.sql</a><br><br>
			les tables qui les sauvegardes et les tables de l'app alpha<br>
			<a href="sql/alpha_thoughts.sql"><i class="fas fa-pager"></i> alpha_thoughts.sql</a><br>
			<a href="sql/alpha_links.sql"><i class="fas fa-pager"></i> alpha_links.sql</a><br>
			<a href="sql/alpha_attachments.sql"><i class="fas fa-pager"></i> alpha_attachments.sql</a><br><br>
			connection à la base<br>
			script à modifier, scripts/inc.connectDB.php<br><br>
			
			
<pre>
En local<br>
$VALUE_hote='localhost';<br>
$VALUE_port='';<br>
$VALUE_nom_bd='database_name';<br>
$VALUE_user='root';<br>
$VALUE_mot_de_passe='';<br>
$connectDB = new PDO('mysql:host='.$VALUE_hote.';port='.$VALUE_port.';dbname='.$VALUE_nom_bd, $VALUE_user, $VALUE_mot_de_passe, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); <br><br>

En ligne<br>
$VALUE_hote='hostpoint.mysql.db.internal';<br>
$VALUE_port='';<br>
$VALUE_nom_bd='database_name';<br>
$VALUE_user='database_user';<br>
$VALUE_mot_de_passe='database_password';<br>
$connectDB = new PDO('mysql:host='.$VALUE_hote.';port='.$VALUE_port.';dbname='.$VALUE_nom_bd, $VALUE_user, $VALUE_mot_de_passe, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); <br><br>
</pre><br>
			Ensuite importer les dossiers à la racine de votre projet.<br>
			<br>
			<br><br><br>
			Une fois que vous êtes ok avec ça direction <a href="importJson.php"><button type="button" name="rec_newFolder" class="btn btn-primary">Importer les données</button></a>
			<br><br><br>
		</div>
	<!-- Optional JavaScript -->
    <?php require_once("scripts/inc.framework.php");?>
</body>
</html>