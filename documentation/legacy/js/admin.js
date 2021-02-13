
$(document).ready(function(){
	$("#adminEditUser").on("click", onEditUserClick);
	$("#adminEditHorse").on("click", onEditHorseClick);
	$("#adminDeleteUser").on("click", onDeleteUserClick);
	$("#adminDeleteHorse").on("click", onDeleteHorseClick);

	$("#deleteDropDown").change(onDeleteDropDownChange);

	$("#deleteConfirmWindowClose").on("click", function(){$("#deleteConfirmPopUp").modal("hide")});
});

// uses AJAX to populate the drop down list of users to edit
function onEditUserClick() {
	cleanOutTheCRUD();
	$.ajax({
			type: "POST",
			url: '../data/fetchdata.php',
			data: {
				table: 'users'
			},
			success: function(data){
				// convert the results from the JSON object
				let results = JSON.parse(data);
				// create the elements
				for(let user of results)
				{
					let option = "<option>" + user[0] + "-" + user[1] + "</option>";
					$("#crudDropDown").append(option);
				}
				// set the other parameters of the modal window
				$("#crudHeader").text("Edit User");
				$("#editForm").attr("action", "adminEditUser.php");
				$("#crudDropDownLabel").text("Choose User to Edit:");
				$("#submitForm").text("Edit User");
				$("#crudPopUp").modal("show");
			}
	});
}

// uses AJAX to populate the drop down list of horses to edit 
function onEditHorseClick() {
	cleanOutTheCRUD();
	$.ajax({
			type: "POST",
			url: '../data/fetchdata.php',
			data: {
				table: 'horses'
			},
			success: function(data){
				// convert the results from the JSON object
				let results = JSON.parse(data);
				// create the elements
				for(let horse of results)
				{
					let option = "<option>" + horse[0] + "-" + horse[1] + "</option>";
					$("#crudDropDown").append(option);
				}
				// set the other parameters of the modal window
				$("#crudHeader").text("Edit Horse");
				$("#editForm").attr("action", "adminEditHorse.php");
				$("#crudDropDownLabel").text("Choose Horse to Edit:");
				$("#submitForm").text("Edit Horse");
				$("#crudPopUp").modal("show");
			}
	});
}

function onDeleteUserClick(){
	cleanOutTheDelete();
	$.ajax({
			type: "POST",
			url: '../data/fetchdata.php',
			data: {
				table: 'users'
			},
			success: function(data){
				// convert the results from the JSON object
				let results = JSON.parse(data);
				// create the elements
				for(let user of results)
				{
					let option = "<option>" + user[0] + "-" + user[1] + "</option>";
					$("#deleteDropDown").append(option);
				}
				// set up the rest of the table
				$("#deleteHeader").text("Delete User");
				$("#deleteSubmit").text("Delete User");
			}
	});
	prepareDeleteModalForUser();
	fetchUserData(1);
	$("#deletePopUp").modal("show");
}

function onDeleteHorseClick(){
	cleanOutTheDelete();
	$.ajax({
			type: "POST",
			url: '../data/fetchdata.php',
			data: {
				table: 'horses'
			},
			success: function(data){
				// convert the results from the JSON object
				let results = JSON.parse(data);
				// create the elements
				for(let horse of results)
				{
					let option = "<option>" + horse[0] + "-" + horse[1] + "</option>";
					$("#deleteDropDown").append(option);
				}
				// set up the rest of the table
				$("#deleteHeader").text("Delete Horse");
				$("#deleteForm").attr("action", "deleteHorse.php");
				$("#deleteSubmit").text("Delete Horse");
			}
	});
	prepareDeleteModalForHorse();
	fetchHorseData(1);
	$("#deletePopUp").modal("show");
}

function fetchHorseData(idValue){
	tidyDeleteModalHorse();
	$.ajax({
		type: "POST",
		url: "../data/fetchRowData.php",
		data: {
			table: 'horses',
			id: idValue
		},
		success: function(data){
			let results = JSON.parse(data);
			$("#deleteName").text(results["name"]);
			$("#deleteSpeed").text(results["speed"]);
			$("#deleteReliability").text(results["reliability"]);
			$("#deleteVariation").text(results["variation"]);
		}
	});
}

function fetchUserData(idValue){
	tidyDeleteModalUser();
	$.ajax({
		type: "POST",
		url: "../data/fetchRowData.php",
		data: {
			table: 'users',
			id: idValue
		},
		success: function(data){
			let results = JSON.parse(data);
			$("#deleteName").text(results["username"]);
			$("#deleteAccount").text(results["account"]);
		}
	});
}

function prepareDeleteModalForUser(){
	$("#objectOutput").empty();
	$("#deleteModalFooter").empty();

	let nameRow = '<div class="row"><div class="col-sm-6"><strong>Name:</strong><p id="deleteName"></p></div></div>';
	let accountRow = '<div class="row"><div class="col-sm-6"><strong>Account:</strong><p id="deleteAccount"></p></div></div>';

	$("#objectOutput").append(nameRow);
	$("#objectOutput").append(accountRow);

	let deleteUserButton = '<button id="deleteUserButton" class="btn btn-default">Delete User</button>';
	$("#deleteModalFooter").append(deleteUserButton);
	$("#deleteUserButton").on("click", deleteUserClick);
}

function prepareDeleteModalForHorse(){
	$("#objectOutput").empty();
	$("#deleteModalFooter").empty();
	let nameRow = '<div class="row"><div class="col-sm-6"><strong>Name:</strong><p id="deleteName"></p></div></div>';
	let speedRow = '<div class="row"><div class="col-sm-6"><strong>Speed:</strong><p id="deleteSpeed"></p></div></div>';
	let reliabilityRow = '<div class="row"><div class="col-sm-6"><strong>Reliability:</strong><p id="deleteReliability"></p></div></div>';
	let variationRow = '<div class="row"><div class="col-sm-6"><strong>Name:</strong><p id="deleteVariation"></p></div></div>';

	$("#objectOutput").append(nameRow);
	$("#objectOutput").append(speedRow);
	$("#objectOutput").append(reliabilityRow);
	$("#objectOutput").append(variationRow);

	let deleteHorseButton = '<button id="deleteHorseButton" class="btn btn-default">Delete Horse</button>';
	$("#deleteModalFooter").append(deleteHorseButton);
	$("#deleteHorseButton").on("click", deleteHorseClick);
}

function tidyDeleteModalUser(){
	$("#delteName").text("");
	$("#deleteAccount").text("");
}

function tidyDeleteModalHorse(){
	$("#deleteName").text("");
	$("#deleteSpeed").text("");
	$("#deleteReliability").text("");
	$("#deleteVariation").text("");
}

function onDeleteDropDownChange(){
	let table = $("#deleteHeader").text();
	if(table == "Delete User")
	{
		let userid = fetchIdFromDropDown();
		fetchUserData(userid);
	}
	if(table == "Delete Horse")
	{
		let horseid = fetchIdFromDropDown();
		fetchHorseData(horseid);
	}
}

function fetchIdFromDropDown(){
	let idNumber = $("#deleteDropDown").val();
	let separatorIndex = idNumber.indexOf("-");
	idNumber = idNumber.substring(0, separatorIndex);
	let id = parseInt(idNumber);
	return id;
}

// cleans out the contents of the crudPopUp so that it can be
// populated by another button click
function cleanOutTheCRUD() {
	$("#crudHeader").text("");
	$("#editForm").attr("action", "");
	$("#crudDropDownLabel").text("");
	$("#crudDropDown").empty();
	$("#submitForm").text("");
}

// cleans out the contents of the deletePopUp so that it can be 
// populated by aother button click
function cleanOutTheDelete() {
	$("#deleteHeader").text("");
	$("#deleteForm").attr("action", "");
	$("#deleteDropDownLabel").text("");
	$("#deleteDropDown").empty();
	$("#deleteSubmit").text("");
}

function deleteHorseClick(){
	let idValue = fetchIdFromDropDown();
	$("#deletePopUp").modal("hide");
	$.ajax({
		type: "POST",
		url: "../data/deleteRowData.php",
		data: {
			table: 'horses',
			id: idValue
		},
		success: function(data){
			$("#deleteConfirmTextBox").empty();
			let deleteHorseConfirm;
			if(data == "success")
			{
				deleteHorseConfirm = '<div class="alert alert-success"><strong>Success! </strong>Horse removed from database.</div>';
			}
			else
			{
				deleteHorseConfirm = '<div class="alert alert-danger"><strong>Error! </strong>There was an error removing the horse from the database.</div>';				
			}
			$("#deleteConfirmTextBox").append(deleteHorseConfirm);
			$("#deleteConfirmPopUp").modal("show");
		},
		error: function(){
			$("#deleteConfirmTextBox").empty();
			let deleteHorseConfirm = '<div class="alert alert-danger"><strong>Error! </strong>There was an error removing the horse from the database.</div>';
			$("#deleteConfirmTextBox").append(deleteHorseConfirm);
			$("#deleteConfirmPopUp").modal("show");
		}
	});
}

function deleteUserClick(){
	let idValue = fetchIdFromDropDown();
	$("#deletePopUp").modal("hide");
	$.ajax({
		type: "POST",
		url: "../data/deleteRowData.php",
		data: {
			table: 'users',
			id: idValue
		},
		success: function(data){
			$("#deleteConfirmTextBox").empty();
			let deleteUserConfirm;
			if(data == "success")
			{
				deleteUserConfirm = '<div class="alert alert-success"><strong>Success! </strong>User removed from database.</div>';
			}
			else
			{
				deleteUserConfirm = '<div class="alert alert-danger"><strong>Error! </strong>There was an error removing the user from the database.</div>';
			}
			$("#deleteConfirmTextBox").append(deleteUserConfirm);
			$("#deleteConfirmPopUp").modal("show");
		},
		error: function(){
			$("#deleteConfirmTextBox").empty();
			let deleteUserConfirm = '<div class="alert alert-danger"><strong>Error! </strong>There was an error removing the user from the database.</div>';
			$("#deleteConfirmTextBox").append(deleteUserConfirm);
			$("#deleteConfirmPopUp").modal("show");
		}
	});
}