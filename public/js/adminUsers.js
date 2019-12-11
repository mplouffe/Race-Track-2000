var ascending = [true, true, true, true];

$(document).ready(function(){
	bindEvents();
});

function bindEvents(){
	$("#userid").on("click", function(){onHorseTableClick("userid", ascending[0]); ascending[0] = !ascending[0];});
	$("#username").on("click", function(){onHorseTableClick("username", ascending[1]); ascending[1] = !ascending[1];});
	$("#useraccount").on("click", function(){onHorseTableClick("account", ascending[2]); ascending[2] = !ascending[2];});
	$("#useradmin").on("click", function(){onHorseTableClick("admin", ascending[3]); ascending[3] = !ascending[3];});
}

function onHorseTableClick(categoryClicked, direction){
	cleanOutTheTable();
	$.ajax({
			type: "POST",
			url: '../data/fetchOrganizedData.php',
			data: {
				table: 'users',
				category: categoryClicked,
				ascending: direction
			},
			success: function(data){
				// convert the results from the JSON object
				let results = JSON.parse(data);
				// create the elements
				for(let user of results)
				{
					let userEditLink = '<a href="adminEditUser.php?dropDownSelect=' + user["userid"] + "-" + user["username"] + '">';
					let userAdmin = user["admin"] == "unlock" ? "true" : "";
					let tableEntry = '<tr>' +
									'<td>' + user["userid"] + '</td>' +
									'<td>' + userEditLink + user["username"] + '</a></td>' +
									'<td>' + user["account"] + '</td>' +
									'<td>' + userAdmin + '</td>' +
								'</tr>';
					$("#userTable").append(tableEntry);
				}
			}
	});
}

function cleanOutTheTable(){
	$("#userTable").empty();
	let userTableHeader = "<tbody><tr>" +
								'<th id="userid" class="col-xs-2"><a href="#">User ID</a></th>' +
								'<th id="username" class="col-xs-4"><a href="#">Username</a></th>' +
								'<th id="useraccount" class="col-xs-4"><a href="#">Account</a></th>' +
								'<th id="useradmin" class="col-xs-2"><a href="#">Admin</a></th>' +
							"</tr></tbody>";
	$("#userTable").append(userTableHeader);
	bindEvents();
}