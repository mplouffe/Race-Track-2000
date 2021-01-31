// SETTING UP
// animation variables
var animate;
var stopAnimation;
var canvas;
var context;
var width = 720;
var height = 480;
var horsey;
var rails01;
var rails02;
var background;
var track;
var horses;
var finishingLine = 600;
var finishLine;
var startLine;

var quarters = [180, 360, 540, 720]

var racingState = 'beginning';

var step = function() {
	if(!stopAnimation)
	{
		update();
		render();
		animate(step);
	}
};

/* update
 * calls update on all the game elements
 */
var update = function(){
	if(racingState == 'beginning')
	{
		openingUI.update();
	}else if(racingState == 'racing')
	{
		for(i=0;i<horses.length;i++)
		{
			horses[i].racingUpdate();
		}
		rails01.update();
		rails02.update();
		background.racingUpdate();
		track.racingUpdate();
		startLine.update();
	}
	else if(racingState == 'atFinishLine')
	{
		for(i=0;i<horses.length;i++)
		{
			horses[i].racingUpdate();
		}
		rails01.update();
		rails02.update();
		background.racingUpdate();
		track.racingUpdate();
		finishLine.update();
	}
	else if(racingState == 'finish')
	{
		for(i=0;i<horses.length;i++)
		{
			horses[i].finishUpdate();
		}
		finishLine.update();
	}
};

/* render
 * renders the new positions of all the game elements after the update
 */
var render = function() {
	context.fillStyle = "#0080B1";
	context.fillRect(0,0,width, height);
	if(racingState == 'beginning')
	{
		track.render();
		background.render();
		rails01.render();
		rails02.render();
		startLine.render();
		for(i=0;i<horses.length;i++)
		{
			horses[i].standingRender();
		}
		openingUI.render();

	}else if(racingState == 'racing')
	{
		track.render();
		background.render();
		rails01.render();
		rails02.render();
		startLine.render();
		for(i=0;i<horses.length;i++)
		{
			horses[i].racingRender();
		}
	}else if(racingState == 'atFinishLine')
	{
		track.render();
		background.render();
		rails01.render();
		rails02.render();
		finishLine.render();
		for(i=0;i<horses.length;i++)
		{
			horses[i].racingRender();
		}
	}else if(racingState == 'finish')
	{
		track.render();
		background.render();
		finishLine.render();
		rails01.render();
		rails02.render();

		for(i=0;i<horses.length;i++)
		{
			horses[i].racingRender();
		}
	}
};





var Horse = function(name, x,y,speed, position){
	this.name = name;
	this.frames = [ [0 , 0],
					[128, 0],
					[256, 0],
					[384, 0],
					[0, 64],
					[128, 64],
					[256, 64]
					];
	this.imageCounter = 0;
	this.frameCounter = 0;
	this.frameOffset = 3;
	this.image = new Image();
	this.image.src = "imgs/horseSpriteSheet.png";
	this.imageWidth = 128;
	this.imageHeight = 64;

	this.x = x;
	this.y = y;
	this.speed = speed;
	this.distanceTraveled = 0;
	this.speedOffset = 1;

	this.position = position;
}

Horse.prototype.racingRender = function(){
	this.frameCounter++;

	if(this.frameCounter > this.frameOffset){

		this.imageCounter--;	
		if(this.imageCounter <= 0){
			this.imageCounter = this.frames.length - 1;
		}
		this.frameCounter = 0;
	}

	context.drawImage(	this.image, 
						this.frames[this.imageCounter][0], this.frames[this.imageCounter][1],
						this.imageWidth, this.imageHeight,
						this.x, this.y,
						this.imageWidth, this.imageHeight);
}

Horse.prototype.standingRender = function(){

	context.drawImage(	this.image,
						384, 64, 
						this.imageWidth, this.imageHeight,
						this.x, this.y,
						this.imageWidth, this.imageHeight);
}


Horse.prototype.racingUpdate = function(){
	
	this.distanceTraveled += this.speed[this.speedOffset - 0];

	if(this.distanceTraveled > quarters[this.speedOffset] && this.speedOffset < this.speedOffset.length - 1)
	{
		this.speedOffset++;
	}
	this.x += this.speed[this.speedOffset -1];

	if(this.x > finishingLine && racingState == 'racing')
	{
		racingState = 'atFinishLine';
	}
}

Horse.prototype.finishUpdate = function(){
	this.x += this.speed[this.speedOffset -1] + 5;

	if(this.x > 720)
	{
		horses.splice(this.position, 1);
	}
}


/***************** BACKGROUND ELEMENTS ****************/
// RAILING //
var Railing = function(x){
	this.y = 240;
	this.x = x;
	this.image = new Image();
	this.image.src = "imgs/railing.png";
	this.imageWidth = 720;
	this.imageHeight = 23;
}
Railing.prototype.render = function(){
	context.drawImage(this.image, this.x, this.y, this.imageWidth, this.imageHeight);
}
Railing.prototype.update = function(){
	this.x -= 4;
	if(this.x <= -720){
		this.x = 720;
	}
}

// BG //
var BG = function(){
	this.x1 = 0;
	this.x2 = 720;
	this.y = 70;

	this.images = ["imgs/BG01.png"];

	this.image01 = new Image();
	this.image02 = new Image();
	this.image01.src = this.images[0];
	this.image02.src = this.images[0];

	this.imageWidth = 720;
	this.imageHeight = 179;
}
BG.prototype.racingUpdate = function(){
	this.x1 -= 2;
	this.x2 -= 2;

	if(this.x1 <= -720)
	{
		this.x1 = 720;
		// let newImage = Math.floor(Math.random() * 3);
		this.image01.src = this.images[0];
	}

	if(this.x2 <= -720)
	{
		this.x2 = 720;
		// let newImage = Math.floor(Math.random() * 3);
		this.image02.src = this.images[0];
	}
}
BG.prototype.render = function(){
	context.drawImage(this.image01, this.x1, this.y, this.imageWidth, this.imageHeight);
	context.drawImage(this.image02, this.x2, this.y, this.imageWidth, this.imageHeight);
}

// TRACK //
var Track = function(){
	this.x1 = 0;
	this.x2 = 720
	this.y = 240;
	this.image = new Image();
	this.image.src = "imgs/dirt.png";
	this.imageWidth = 720;
	this.imageHeight = 240;
}
Track.prototype.racingUpdate = function(){
	this.x1 -= 4.5;
	this.x2 -= 4.5;
	if(this.x1 <= -720){
		this.x1 = 720;
	}
	if(this.x2 <= -720)
	{
		this.x2 = 720;
	}
}
Track.prototype.render = function(){
	context.drawImage(this.image, this.x1, this.y, this.imageWidth, this.imageHeight);
	context.drawImage(this.image, this.x2, this.y, this.imageWidth, this.imageHeight);
}

/**************** OPENING UI ***********************/
var OpeningUI = function(){
	this.x = 360;
	this.y = 240;
	this.countdown = 3;
	this.cycles = 0;
}

OpeningUI.prototype.update = function(){
	this.cycles++;
	if(this.cycles > 60)
	{
		this.cycles = 0;
		this.countdown--;
	}

	if(this.countdown < 1)
	{
		racingState = 'racing';
		return;
	}
}
OpeningUI.prototype.render = function(){
	context.font = "80px Impact";
	context.fillStyle = "#000";
	context.fillText(this.countdown, this.x, this.y);
}

/************** FINISH LINE *********************/
var FinishLine = function(){
	this.x = 720;
	this.y = 250;
	this.imageHeight = 230;
	this.imageWidth = 48;

	this.speed = 4.5;
	this.image = new Image();
	this.image.src = "imgs/finishLine.png";
	this.countdown = false;
	this.counter = 300;
}

FinishLine.prototype.render = function(){
	context.drawImage(this.image, this.x, this.y, this.imageWidth, this.imageHeight);
}

FinishLine.prototype.update = function(){
	if(this.x >= 600)
	{
		this.x -= this.speed;
	}

	if(this.x <= 600)
	{
		racingState = 'finish';
		this.countdown = true;
	}

	if(this.countdown)
	{
		this.counter--;
		if(this.counter <= 0)
		{
			this.countdown = false;
			$("#raceResults").modal("show");
			stopAnimation = true;
		}
	}
}

var StartLine = function(){
	this.x = 128;
	this.y = 240;
	this.onScreen = true;
	this.image = new Image();
	this.image.src = "imgs/finishLine.png";

}

StartLine.prototype.render = function(){
	if(this.onScreen)
	{
		context.drawImage(this.image, this.x, this.y, this.imageWidth, this.imageHeight);
	}
}

StartLine.prototype.update = function(){
	if(this.onScreen)
	{
		this.x -= this.speed;
		if(this.x < 0 -this.imageWidth)
		{
			this.onScreen = false;
		}
	}
}



$(document).ready(function(){

	// SET UP THE REPLAY WINDOW
	animate = window.requestAnimationFrame ||
	window.webkitRequestAnimationFrame ||
	window.mozRequestAnimationFrame ||
	function(callback) { window.setTimeout(callback, 1000/60) };
	stopAnimation = false;
	canvas = document.getElementsByTagName('canvas')[0];
	canvas.width = width;
	canvas.height = height;
	context = canvas.getContext('2d');

	// SET UP THE GAME OBJECTS
	rails01 = new Railing(0);
	rails02 = new Railing(720);
	background = new BG();
	track = new Track();
	finishLine = new FinishLine();
	openingUI = new OpeningUI();
	startLine = new StartLine();

	// MAKE THE AJAX REQUEST FOR THE HORSE RACE RESULTS
	$.ajax({
			type: "POST",
			url: 'calculateRace.php',
			data: $_POST,
			success: function(data){

				if(data == "null")
				{
					$(location).attr("href", "user.php");
				}
				else
				{
					// convert the results from the JSON object
					let results = JSON.parse(data);
					// create the horses
					let returnedHorses = results[2];
					horses = [
						new Horse(returnedHorses['name'], 0, 220, [returnedHorses[0]['race'][0], returnedHorses[0]['race'][1], returnedHorses[0]['race'][2], returnedHorses[0]['race'][3]], 0),
						new Horse(returnedHorses['name'], 0, 265, [returnedHorses[1]['race'][0], returnedHorses[1]['race'][1], returnedHorses[1]['race'][2], returnedHorses[1]['race'][3]], 1),
						new Horse(returnedHorses['name'], 0, 310, [returnedHorses[2]['race'][0], returnedHorses[2]['race'][1], returnedHorses[2]['race'][2], returnedHorses[2]['race'][3]], 2),
						new Horse(returnedHorses['name'], 0, 355, [returnedHorses[3]['race'][0], returnedHorses[3]['race'][1], returnedHorses[3]['race'][2], returnedHorses[3]['race'][3]], 3),
						new Horse(returnedHorses['name'], 0, 400, [returnedHorses[4]['race'][0], returnedHorses[4]['race'][1], returnedHorses[4]['race'][2], returnedHorses[4]['race'][3]], 4)
					];

					// create the result ticket
					let bet = results[0];
					let betResult = results[1];
					let winners = results[3];

					// populate the result table
					$("#first").html(winners[0].name);
					$("#second").html(winners[1].name)
					$("#third").html(winners[2].name)
					$("#fourth").html(winners[3].name)
					$("#fifth").html(winners[4].name)

					// create the output at the bottom
					let header, lineTwo = "";
					if(betResult < 0)
					{
						header = "<h1>You Loose</h1>";
						bet = bet * -1;
						lineTwo = "<p>You lost $" + betResult + "</p>"
					}
					else
					{
						header = "<h1>You Win</h1>";
						lineTwo = "<p>You won $" + betResult + "</p>";
					}
					$("#resultText").append(header);
					$("#resultText").append(lineTwo);

					animate(step);
				}
			}
	});


	$("#goHome").on("click", function(){
		$(location).attr("href", "user.php");
	});
});

