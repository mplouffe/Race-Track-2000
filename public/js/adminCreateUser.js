

// attach elements to the interactive page elements
$(document).ready(function(){

	$("#submitForm").on("click", validateInput);
	
	$("#adminCheckBox").change(function(){
		if($(this).is(":checked")) {
			let returnVal = confirm("Are you sure you want to promote this user to an Admin?");
			$(this).prop("checked", returnVal);
		}
	});

	$("#username").blur(checkUsername);

	$("#cancel").on("click", cancelCreate);
});

function validateInput(){

	let hasErrors = false;

	$(".alert").hide();
	$(".alert").html("");
	// do some client side validation to smooth over the interaction
	// check the username for a length of at least 4
	let username = $("#username").val();
	username = username.trim();
	if($("username").attr("error") == "true")
	{
		let errorMessage = "Username is unavialable.";
		$("#usernameError").append(errorMessage);
		$("usernameError").show();
		if(!hasErrors)
		{
			hasErrors = true;
			$("#username").focus();
		}
	}

	if(username.length == 0)
	{
		let errorMessage = "<strong>Error! </strong>Username must be at least 4 characters long.";
		$("#usernameError").append(errorMessage);
		$("#usernameError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#username").focus();
		}
	}

	// check the account for a numeric value
	let account = $("#account").val();
	if(isNaN(account))
	{
		let errorMessage = "<strong>Error! </strong>Account amount must be a numeric value.";
		$("#accountError").append(errorMessage);
		$("#accountError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#accountF").focus();
		}
	}

	// check the password fields
	let password = ($("#password").val()).trim();
	if(password != "")
	{
		let passwordConfirm = ($("#passwordConfirm").val()).trim();

		if(password.length < 4)
		{
			let errorMessage = "<strong>Error! </strong>Password must be at least 4 characters.";
			$("#passwordError").append(errorMessage);
			$("#passwordError").show();
			if(!hasErrors){
				hasErrors = true;
				$("#password").focus();
			}
		}
		else if(password != passwordConfirm)
		{
			let errorMessage = "<strong>Error! </strong>Both password fields must match.";
			$("#passwordError").append(errorMessage);
			$("#passwordError").show();
			if(!hasErrors){
				hasErrors = true;
				$("#password").focus();
			}
		}
	}
	else
	{
		let errorMessage = "<strong>Error! </strong>You must enter a password.";
		$("#passwordError").append(errorMessage);
		$("#passwordError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#password").focus();
		}
	}

	if(!hasErrors)
	{
		let finalCheck = confirm("Create this user?");
		if(finalCheck)
		{
			$("#createUserForm").submit();
		}
		else
		{
			$("#username").focus();
		}
	}
}

function cancelCreate(){
	window.location.replace('admin.php');
}

function checkUsername(){
	let inputUsername = $("#username").val();
	console.log(inputUsername);
	$.ajax({
			type: "POST",
			url: '../data/checkname.php',
			data: {
				table: 'users',
				name: inputUsername
			},
			success: function(data){
				let results = JSON.parse(data);

				$("#usernameError").html("");
				if(results["response"] == "true")
				{
					$("#usernameError").attr("class", "alert alert-success");
					$("#usernameError").html("Username is available.");
					$("#usernameError").attr("error", "false");
				}
				else
				{
					$("#usernameError").attr("class", "alert alert-warning");
					$("#usernameError").html("Username is unavailable.");
					$("#usernameError").attr("error", "true");
				}
				$("#usernameError").show();
			}
	});
}