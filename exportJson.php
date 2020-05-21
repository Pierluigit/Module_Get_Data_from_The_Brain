<?php
///////////////////////////////////////////
///////////////////////////////////////////
/////// Modular Project The Brain /////////
///////////////////////////////////////////
///////////////////////////////////////////
// Title: Export to The Brain
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
$page = "exportJson";
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
		<?php require_once("scripts/inc.nav.php");?>
	</div>
			
			
	
	<!-- Optional JavaScript -->
    <?php require_once("scripts/inc.framework.php");?>
</body>
</html>