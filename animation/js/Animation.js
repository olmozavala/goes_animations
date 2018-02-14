/**
 * 
 * @type type
 */
class Animation{
	/**
	 * This is the constructor of the function
	 * @param {type} imgNames List of images we want to load
	 * @param {type} canvasId Canvas id where tu run the animation
	 * @param {type} globalObjectName Name of the object will have this instance
	 * @returns {Animation}
	 */
	constructor(imgNames, canvasId, globalObjectName){
		this.imgNames = imgNames;
		this.canvas = document.getElementById(canvasId);
		this.ctx = this.canvas.getContext("2d");
		this.totImgs = imgNames.length;
		this.totImgLoaded = 0;
		this.images = [];
		this.status = 'pause';
		this.currImg = 0;
		this.currSpeed =  1;//1 Frame por segundo
		this.name = globalObjectName;
	}

	updateSize(){
		//Gets the width from the parent element
		this.canvas.width = $(this.canvas.parentNode).width();
		this.canvas.height = this.canvas.width*.6;
	}
	//This function starts the animation and receives the
	// size of the canvas with respect to the size of the window 
	init(){
		this.updateSize();

		for (var i = 0; i < this.totImgs; i++){  
			this.images[i] = new Image();
			this.images[i].src = this.imgNames[i];
			this.images[i].onload = this.imagesloaded(this);
		}
	}	

	//This is a weird function because it calls
	// its own object with 
	imagesloaded(obj, img){
		this.totImgLoaded += 1;

		if(this.status !== 'play'){
			if(this.totImgLoaded > this.totImgs*.3){ 
				$("#"+obj.name+"_lastimage").html(obj.totImgs);
				$("#"+obj.name+"_speed").html(obj.currSpeed);
				this.status = 'play';
				animate(this.name)
			}
		}
	}

	nextImg(){
		this.currImg +=1;
		if(this.currImg === this.totImgs){
			this.currImg = 0;
		}
	}

}

/**
 *  This function is in charge of animating one of the Animation objects. 
 * @param {type} objName String containing the name of the object to animate. 
 * @returns {undefined}
 */
function animate(objName){
	var obj = eval(objName);	

	if(obj.status === 'play'){
		
		draw_image(objName);
		obj.nextImg();
		obj.timer = setTimeout("animate('"+objName+"')", 1000/obj.currSpeed);
	}
}

//===> stop the movie
function stop(objName)
{       
	var obj = eval(objName);	
	clearTimeout(obj.timer);       
	toggledisplay(objName+ 'btn_play');
	toggledisplay(objName+ 'btn_stop');
	toggledisplay(objName+ 'btn_ffwd');
	toggledisplay(objName+ 'btn_frwd');
	toggledisplay(objName+ 'btn_next');
	toggledisplay(objName+ 'btn_prev');          
	obj.status = 'paused';
	$("#"+obj.name+"_speed_container").hide();
}


//===> "play "
function play(objName)
{
	var obj = eval(objName);	
	stop(objName);//Stop first, just in case there is something playing
	obj.status = 'play';
	animate(objName);
	$("#"+obj.name+"_speed_container").show();
}

/**
 * Draws the current image 
 * @param {type} objName
 * @returns {undefined}
 */
function draw_image(objName){
	var obj = eval(objName);	

	var w = obj.images[obj.currImg].width;
	var h = obj.images[obj.currImg].height;
	// resize img to fit in the canvas 
	// You can alternately request img to fit into any specified width/height
	var sizer = scalePreserveAspectRatio(w, h, obj.canvas.width, obj.canvas.width);
	obj.canvas.height = obj.canvas.width * (h/w);
//	$("#"+objName+"_frame_num").val(obj.currImg);
	obj.ctx.drawImage(obj.images[obj.currImg], 0, 0, w, h, 0, 0, w * sizer, h * sizer);
}

//===> jumps to a given image number
function go2image(objName, number)
{
	var obj = eval(objName);	
	if (number >= obj.totImgs){
		number = 0;
	}
	if (number < 0){
		number = obj.totImgs-1;
	}
	obj.currImg = number;
	draw_image(objName);
}

function change_speed(objName, inc)
{
	var obj = eval(objName);	
	obj.currSpeed =  obj.currSpeed + inc;
	if(obj.currSpeed < 1){
		obj.currSpeed = (obj.currSpeed-inc)/2;
	}else{
		obj.currSpeed = Math.floor(obj.currSpeed);
	}

	$("#"+obj.name+"_speed").html(obj.currSpeed);
}
