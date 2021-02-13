$(document).ready(function(){
	$("#deleteImage").on("click", onDeleteClick);
	$("#editHorse").on("click", onEditHorseClick);
});

function onDeleteClick(){
	let deleteConfirm = confirm("Are you sure you want to remove this profile image?");
	if(deleteConfirm)
	{
		$("#deleteImage").attr("value", "remove");
		$("#uploadImageForm").submit();
	}
}

function onEditHorseClick(){
	console.log("sanity Check");
	let horseInfo = $("#editHorse").val();
	let redirect = "adminEditHorse.php?dropDownSelect=" + horseInfo;

	window.location.href = redirect;
}