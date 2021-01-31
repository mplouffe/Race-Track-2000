$(document).ready(function(){
	$("#editUser").on("click", onEditUserClick);
});

function onEditUserClick(){
	let userInfo = $("#editUser").val();
	let redirect = "adminEditUser.php?dropDownSelect=" + userInfo;

	window.location.href = redirect;
}