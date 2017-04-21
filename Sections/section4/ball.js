var acceleration;
var velocity;
var position;

window.onload = function(){
	acceleration = 1;
	velocity = 0;
	position = 0;

	var ball = document.getElementById("ball");
	ball.style.top = "0px";
	ball.style.left = "300px";

	setInterval(bounce,20);
}

function bounce(){
	var ball = document.getElementById("ball");

	if(parseInt(ball.style.top) > 400){
		velocity = -3/4 * velocity;
	}

	position += velocity;
	velocity += acceleration;

	ball.style.top = position + "px";

}