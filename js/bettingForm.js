var pickform = {"racetype":0, "picktype":0, "pick00":0, "pick01":0, "pick02": 0};


$(document).ready(function(){
	$("#single").on("click", processSingleClick);
	$("#multi").on("click", processMultiClick);
	
	$("#singleShow").on("click", processSingleShowClick);
	$("#singlePlace").on("click", processSinglePlaceClick);
	$("#singleWin").on("click", processSingleWinClick);

	$("#multiQuin").on("click", processMultiQuin);
	$("#multiExac").on("click", processMultiExac);
	$("#multiTri").on("click", processMultiTri);

	$("#horseA").on("click", processHorseAClick);
	$("#horseB").on("click", processHorseBClick);
	$("#horseC").on("click", processHorseCClick);
	$("#horseD").on("click", processHorseDClick);
	$("#horseE").on("click", processHorseEClick);

	$("#betButton").on("click", processBetClick);

	$("#betInput").numeric(null, numericCallbackFunction);


});

// LAYER 01 //
function processSingleClick(){
	if(!$("#singleType").is(":visible"))
	{
		$("#singleType").show();
		$(".multiPickClass").hide();
		$("#pickButtons").hide();
		clearChoices();
		pickform["racetype"] = "single";
	}
}

function processMultiClick(){
	if(!$("#multiType").is(":visible"))
	{
		$(".singlePickClass").hide();
		$("#multiType").show();
		$("#pickButtons").hide();
		clearChoices();
		pickform["racetype"] = "multi";
	}
}

function clearChoices(){
	$(".pickButtons").show();
	$(".pickForm").hide();
	$(".pickContents").empty();
	resetBetBox();
}

// LAYER 02 //
function processSingleShowClick(){
	clearChoices();
	$("#singlePickForm").show();
	$("#singlePickHeader").show();
	$("#singlePickChoice").show();
	$("#pickButtons").show();
	pickform["picktype"] = "show";
	resetHorseButtons();
}

function processSinglePlaceClick(){
	clearChoices();
	$("#singlePickForm").show();
	$("#singlePickHeader").show();
	$("#singlePickChoice").show();
	$("#pickButtons").show();
	pickform["picktype"] = "place";
	resetHorseButtons();
}

function processSingleWinClick(){
	clearChoices();
	$("#singlePickForm").show();
	$("#singlePickHeader").show();
	$("#singlePickChoice").show();
	$("#pickButtons").show();
	pickform["picktype"] = "win";
	resetHorseButtons();
}

function processMultiQuin(){
	clearChoices();
	$("#multiPickForm").show();
	$(".pickContentsThree").hide();
	$("#multiPickHeader01").append('<p>Pick One</p>');
	$("#multiPickHeader01").show();
	$("#multiPickHeader02").append('<p>Pick One</p>');
	$("#mutliPickHeader02").show();

	$("#multiPickChoice01").show();
	$("#multiPickChoice02").show();

	$("#pickButtons").show();
	pickform["picktype"] = "quinella"
	resetHorseButtons();
}

function processMultiExac(){
	clearChoices();
	$("#multiPickForm").show();
	$(".pickContentsThree").hide();
	$("#multiPickHeader01").append('<p>First Place</p>');
	$("#multiPickHeader01").show();
	$("#multiPickHeader02").append('<p>Second Place</p>');
	$("#multiPickHeader02").show();

	$("#multiPickChoice01").show();
	$("#multiPickChoice02").show();

	$("#pickButtons").show();

	pickform["picktype"] = "exacta";
	resetHorseButtons();
}

function processMultiTri(){
	clearChoices();
	$("#multiPickForm").show();
	$(".pickContentsThree").show();
	$("#multiPickHeader01").append('<p>First Place</p>');
	$("#multiPickHeader01").show();
	$("#multiPickHeader02").append('<p>Second Place</p>');
	$("#multiPickHeader02").show();
	$("#multiPickHeader03").append('<p>Third Place</p>');
	$("#multiPickHeader03").show();

	$("#multiPickChoice01").show();
	$("#multiPickChoice02").show();
	$("#multiPickChoice03").show();

	$("#pickButtons").show();

	pickform["picktype"] = "trifecta";
	resetHorseButtons();
	resetBetBox();
}

// LAYER 3 //
function processHorseAClick(){processHorseClick($("#horseA").text());}
function processHorseBClick(){processHorseClick($("#horseB").html());}
function processHorseCClick(){processHorseClick($("#horseC").html());}
function processHorseDClick(){processHorseClick($("#horseD").html());}
function processHorseEClick(){processHorseClick($("#horseE").html());}


function processHorseClick(horseName){
	let horseClassId = "#" + horseName;
	$(horseClassId).prop('disabled', true);

	switch(pickform["picktype"])
	{
		case "place":
		case "show":
		case "win":
			$("#singlePickChoice").append("<p>" + horseName + "</p>");
			pickform["pick00"] = horseName;
			turnOnBettingBox();
			disableHorseButtons();
			break;
		case "quinella":
		case "exacta":
			if(pickform["pick00"] == 0)
			{
				pickform["pick00"] = horseName;
				$("#multiPickChoice01").append("<p>" + horseName + "</p>");
			}
			else
			{
				pickform["pick01"] = horseName;
				turnOnBettingBox();
				$("#multiPickChoice02").append("<p>" + horseName + "</p>");
				disableHorseButtons();
			}
			break;
		case "trifecta":
			if(pickform["pick00"] == 0)
			{
				pickform["pick00"] = horseName;
				$("#multiPickChoice01").append("<p>" + horseName + "</p>");
			}
			else if(pickform["pick01"] == 0)
			{
				pickform["pick01"] = horseName;
				$("#multiPickChoice02").append("<p>" + horseName + "</p>");
			}
			else
			{
				pickform["pick02"] = horseName;
				turnOnBettingBox();
				$("#multiPickChoice03").append("<p>" + horseName + "</p>");
				disableHorseButtons();
			}
			break;
	}
}

var numericCallbackFunction = function(eventArgs){
	errorMessage = "<strong>Error!</strong></br>Your bet must be a number!";
	setErrorMessage(errorMessage);
}

function turnOnBettingBox(){
	$(".betSection").show();
	$("#placeBet").show();
}

function resetBetBox(){
	$(".betSection").hide();
	$("#betInput").val("");
	$("#placeBet").hide();
}

function resetHorseButtons(){
	$("#horseA").show();
	$("#horseB").show();
	$("#horseC").show();
	$("#horseD").show();
	$("#horseE").show();

	$("#horseA").prop('disabled', false);
	$("#horseB").prop('disabled', false);
	$("#horseC").prop('disabled', false);
	$("#horseD").prop('disabled', false);
	$("#horseE").prop('disabled', false);

	pickform["pick00"] = 0;
	pickform["pick01"] = 0;
	pickform["pick02"] = 0;

	$("#betSection").hide();
}

var disableHorseButtons = function(){
	$("#horseA").prop('disabled', true);
	$("#horseB").prop('disabled', true);
	$("#horseC").prop('disabled', true);
	$("#horseD").prop('disabled', true);
	$("#horseE").prop('disabled', true);
}

function getCookie(cname) {
	let name = cname + "=";
	let ca = document.cookie.split(';');
	for(let i = 0; i < ca.length; i++)
	{
		let c= ca[i];
		while(c.charAt(0)==' '){
			c = c.substring(1);
		}
		if(c.indexOf(name) == 0)
		{
			return c.substring(name.length,c.length);
		}
	}
	return "";
}

function processBetClick() {

	$("#betError").html("");
	$("#betError").hide();

	let betErrorMessage = "";
	let bet = parseFloat($("#betInput").val());

	if(bet < 0)
	{
		betErrorMessage = "<strong>Error!</strong></br>You must bet a positive amount!";
	}

	if(document.cookie != "" && betErrorMessage == "")
	{
		let bank = parseFloat(getCookie("userBank"));
		let playerMinBet = parseFloat(getCookie("playerMinBet"));

		if(pickform["picktype"] == "quinella" || pickform["picktype"] == "exacta")
		{
			playerMinBet *= 2;
		}
		else if(pickform["picktype"] == "trifecta")
		{
			playerMinBet *= 3;
		}

		if(bet < playerMinBet)
		{
			betErrorMessage = "<strong>Error!</strong></br>You must bet at least " + playerMinBet;
		}
		else if(bet > bank)
		{
			betErrorMessage = "<strong>Error!</strong></br>You can't bet more than your max amount which is: " + bank;
		}
	}

	if(betErrorMessage != "")
	{
		setErrorMessage(betErrorMessage)
	}
	else
	{
		$("#racetype").append(pickform["racetype"]);
		$("#picktype").append(pickform["picktype"]);
		$("#bet").append(bet);

		let racetype = '<input name="racetype" type="hidden" value="' + pickform["racetype"] + '">';
		let picktype = '<input name="picktype" type="hidden" value="' + pickform["picktype"] + '">';
		let betPost = '<input name="bet" type="hidden" value="' + bet + '">';

		let horsePick01 = '<input name="horse01" type="hidden" value="' + pickform["pick00"] + '">';
		let horsePick02 = '<input name="horse02" type="hidden" value="' + pickform["pick01"] + '">';
		let horsePick03 = '<input name="horse03" type="hidden" value="' + pickform["pick02"] + '">';
		
		$("#betForm").append(racetype);
		$("#betForm").append(picktype);
		$("#betForm").append(betPost);
		$("#betForm").append(horsePick01);
		$("#betForm").append(horsePick02);
		$("#betForm").append(horsePick03);

		$("#betConfirm").modal("show");
	}
}

function setErrorMessage(errorMessage){
	$("#betError").append(errorMessage);
	$("#betError").show();
	$("#betInput").select();
	$("#betInput").focus();
}