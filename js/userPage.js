
$(document).ready(function(){
	$("#race01").on("click", betRace01);
	$("#race02").on("click", betRace02);	
	$("#race03").on("click", betRace03);
});

function betRace01(){
	let url = "betting.php?race=01";
	$(location).attr('href', url);
}

function betRace02(){
	let url = "betting.php?race=02";
	$(location).attr('href', url);
}

function betRace03(){
	let url = "betting.php?race=03";
	$(location).attr('href', url);
}