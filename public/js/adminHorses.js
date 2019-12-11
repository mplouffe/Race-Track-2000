var ascending = [true, true, true, true, true];

$(document).ready(function(){
	bindEvents();
});

function bindEvents(){
	$("#horseid").on("click", function(){onHorseTableClick("horseid", ascending[0]); ascending[0] = !ascending[0];});
	$("#horsename").on("click", function(){onHorseTableClick("name", ascending[1]); ascending[1] = !ascending[1];});
	$("#horsespeed").on("click", function(){onHorseTableClick("speed", ascending[2]); ascending[2] = !ascending[2];});
	$("#horsereliability").on("click", function(){onHorseTableClick("reliability", ascending[3]); ascending[3] = !ascending[3];});
	$("#horsevariation").on("click", function(){onHorseTableClick("variation", ascending[4]); ascending[4] = !ascending[4];});
}

function onHorseTableClick(categoryClicked, direction){
	cleanOutTheTable();
	$.ajax({
			type: "POST",
			url: '../data/fetchOrganizedData.php',
			data: {
				table: 'horses',
				category: categoryClicked,
				ascending: direction
			},
			success: function(data){
				// convert the results from the JSON object
				let results = JSON.parse(data);
				// create the elements
				for(let horse of results)
				{
					let horseEditLink = '<a href="adminEditHorse.php?dropDownSelect=' + horse["horseid"] + "-" + horse["name"] + '">';
					let tableEntry = '<tr>' +
									'<td>' + horse["horseid"] + '</td>' +
									'<td>' + horseEditLink + horse["name"] + '</a></td>' +
									'<td>' + horse["speed"] + '</td>' +
									'<td>' + horse["reliability"] + '</td>' +
									'<td>' + horse["variation"] + '</td>' +
								'</tr>';
					$("#horseTable").append(tableEntry);
				}
			}
	});
}

function cleanOutTheTable(){
	$("#horseTable").empty();
	let horseTableHeader = "<tbody><tr>" +
								'<th id="horseid" class="col-xs-2"><a href="#">Horse ID</a></th>' +
								'<th id="horsename" class="col-xs-4"><a href="#">Name</a></th>' +
								'<th id="horsespeed" class="col-xs-2"><a href="#">Speed</a></th>' +
								'<th id="horsereliability" class="col-xs-2"><a href="#">Reliability</a></th>' +
								'<th id="horsevariation" class="col-xs-2"><a href="#">Variation</a></th>' +
							"</tr></tbody>";
	$("#horseTable").append(horseTableHeader);
	bindEvents();
}
