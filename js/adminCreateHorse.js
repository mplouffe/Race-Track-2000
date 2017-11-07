

var horseName;

// attach elements to the interactive page elements
$(document).ready(function(){

	$("#submitForm").on("click", validateInput);

	$("#cancel").on("click", cancelEdit);

	$("#speed").numeric(null, numericCallbackFunction);
	$("#reliability").numeric(null, numericCallbackFunction);
	$("#variation").numeric(null, numericCallbackFunction);

	horseName = $("#name").val();

	$("#name").blur(checkHorsename);
});

function validateInput(){

	let hasErrors = false;

	$(".alert").hide();
	$(".alert").html("");
	// do some client side validation to smooth over the interaction
	// check the username for a length of at least 4
	let horsename = $("#name").val();
	horsename = horsename.trim();
	if(horsename.length < 0)
	{
		let errorMessage = "<strong>Error! </strong>Horse Name must be at least 4 characters long.";
		$("#nameError").append(errorMessage);
		$("#nameError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#name").focus();
		}
	}

	// check the account for a numeric value
	let speed = $("#speed").val();
	if(isNaN(speed))
	{
		let errorMessage = "<strong>Error! </strong>Speed must be a numeric value.";
		$("#speedError").append(errorMessage);
		$("#speedError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#speed").focus();
		}
	} else if(parseInt(speed) < 50 || parseInt(speed) > 100)
	{
		let errorMessage = "<strong>Error! </strong>Speed must be greater than 50 and less then 100.";
		$("#speedError").append(errorMessage);
		$("#speedError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#speed").focus();
		}
	}

	let reliability = $("#reliability").val();
	if(isNaN(reliability))
	{
		let errorMessage = "<strong>Error! </strong>Reliability must be a numeric value. " + reliability;
		$("#reliabilityError").append(errorMessage);
		$("#reliabilityError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#reliability").focus();
		}
	} else if(parseInt(reliability) < 50 || parseInt(reliability) > 100)
	{
		let errorMessage = "<strong>Error! </strong>Reliability must be greater than 50 and less then 100.";
		$("#reliabilityError").append(errorMessage);
		$("#reliabilityError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#reliability").focus();
		}
	}

	let variation = $("#variation").val();
	if(isNaN(variation))
	{
		let errorMessage = "<strong>Error! </strong>Variation must be a numeric value. " + variation;
		$("#variationError").append(errorMessage);
		$("#variationError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#variation").focus();
		}
	} else if(parseInt(variation) < 50 || parseInt(variation) > 100)
	{
		let errorMessage = "<strong>Error! </strong>Variation must be greater than 50 and less then 100.";
		$("#variationError").append(errorMessage);
		$("#variationError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#variation").focus();
		}
	}

	if(!hasErrors)
	{
		let finalCheck = confirm("Create this Horse?");
		if(finalCheck)
		{
			$("#createHorseForm").submit();
		}
		else
		{
			$("#name").focus();
		}
	}
}

function cancelEdit(){
	window.location.replace('admin.php');
}

function numericCallbackFunction(){

}

function checkHorsename(){
	let inputHorsename = $("#name").val();

	$("#nameError").html("");
	$("#nameError").hide();
	$("#nameError").attr({
		class: "alert",
		error: ""
	});
	if(inputHorsename != horseName)
	{
		$.ajax({
				type: "POST",
				url: '../data/checkname.php',
				data: {
					table: 'horses',
					name: inputHorsename
				},
				success: function(data){
					let results = JSON.parse(data);

					if(results["response"] == "true")
					{
						$("#nameError").attr("class", "alert alert-success");
						$("#nameError").html("Name is available.");
						$("#nameError").attr("error", "false");
					}
					else
					{
						$("#nameError").attr("class", "alert alert-warning");
						$("#nameError").html("Name is unavialable.");
						$("#nameError").attr("error", "true");
					}
					$("#nameError").show();
				}
		});
	}
}