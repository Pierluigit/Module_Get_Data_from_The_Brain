// JavaScript Document
//////////////////////////////////////
// bloque clic droite et selection
function disableselect(e){ 
	"use strict";
	return false;
} 

function reEnable(){ 
	"use strict";
	return true; 
} 
//if IE4+ 
document.onselectstart=new Function ("return false");
document.oncontextmenu=new Function ("return false"); 
//if NS6 
if (window.sidebar){ 
//document.onmousedown=disableselect 
document.onclick=reEnable;
}
///////////////////////////////////////////

//////////////////////////////  
// ======= update table request
function defineWhichBackup() { 
	"use strict";
	var value = document.getElementById("defineWhichBackup").value;

	var formData = {value:value};
	$.ajax(
	{
	url : "scripts/defineWhichBackup.php",
	type: "POST",
	data : formData,
	success: function()
	{
		//alert('youpi');
		location.reload();
	},
	error: function()
	{
		//alert('pas ok');
	}
	});
}
//////////////////////////////
function rec_champRequest(idUser, idRequest, champ) { 
	"use strict";
	var value = document.getElementById(champ).value;
	
	var formData = {idUser:idUser, idRequest:idRequest, value:value, champ:champ};
	$.ajax(
	{
	url : "scripts/rec_champRequest.php",
	type: "POST",
	data : formData,
	success: function(data)
	{
		//alert('youpi');
		// si le champ est centre de travaux reload la page
		if((champ==="idCentreTravaux") || (champ==="idService")) { 
		   location.reload(); 
		}
		// affiche ok
		document.getElementById('confirm_'+champ).innerHTML = ""+ data + "";
		$("#confirm_"+champ).css("opacity", "100"); 
		function closeConfirme() {
			$('#confirm_'+champ).animate({opacity: 0},1000);
		}
		setTimeout(closeConfirme, 4000);
	},
	error: function()
	{
		//alert('pas ok');
		document.getElementById('confirm_'+champ).innerHTML = 'Erreur ajax !';
		$("#confirm_"+champ).css("opacity", "100"); 
		function closeConfirme() {
			$('#confirm_'+champ).animate({opacity: 0},1000);
		}
		setTimeout(closeConfirme, 4000);
	}
	});
}