

// attach elements to the interactive page elements
$(document).ready(function(){

	$("#submitForm").on("click", validateInput);
	
	$("#userid").prop("readonly", true);
	
	$("#adminCheckbox").change(function(){
		if($(this).is(":checked")) {
			let returnVal = confirm("Are you sure you want to promote this user to an Admin?");
			$(this).prop("checked", returnVal);
		}else{
			let returnVal = confirm("Are you sure you want to remove Admin privliges from this account?");
			$(this).prop("checked", !returnVal);
		}
	});

	$("#cancel").on("click", cancelEdit);
});

function validateInput(){

	let hasErrors = false;

	$(".alert").hide();
	$(".alert").html("");
	// do some client side validation to smooth over the interaction
	// check the username for a length of at least 4
	let username = $("#username").val();
	username = username.trim();
	if(username.length == 0)
	{
		let errorMessage = "<strong>Error!</strong>Username must be at least 4 characters long.";
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
		let errorMessage = "<strong>Error!</strong>Account amount must be a numeric value.";
		$("#accountError").append(errorMessage);
		$("#accountError").show();
		if(!hasErrors){
			hasErrors = true;
			$("#account").focus();
		}
	}

	// check the password fields
	let password = ($("#password").val()).trim();
	if(password != "")
	{
		let passwordConfirm = ($("#passwordConfirm").val()).trim();

		if(password.length < 4)
		{
			let errorMessage = "<strong>Error!</strong>Password must be at least 4 characters.";
			$("#passwordError").append(errorMessage);
			$("#passwordError").show();
			if(!hasErrors){
				hasErrors = true;
				$("#password").focus();
			}
		}
		else if(password != passwordConfirm)
		{
			let errorMessage = "<strong>Error!</strong>Both password fields must match.";
			$("#passwordError").append(errorMessage);
			$("#passwordError").show();
			if(!hasErrors){
				hasErrors = true;
				$("#password").focus();
			}
		}
	}

	if(!hasErrors)
	{
		let finalCheck = confirm("Commit changes to this user?");
		if(finalCheck)
		{
			$("#editUserForm").submit();
		}
		else
		{
			$("#username").focus();
		}
	}
}

function cancelEdit(){
	window.location.replace('admin.php');
}