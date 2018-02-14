/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var goesAnimation;
$( window ).resize(function() {
	goesAnimation.updateSize();
});

function initCalendars(){

    var today = moment();
    var tomorrow = moment();
    tomorrow.add(1,'d');
    //var yesterday = moment('2017/11/07');

	//Init datetimes
	$('#startDatePicker').datetimepicker({
		format:'L',
        defaultDate: today,
	});
	$('#endDatePicker').datetimepicker({
		format:'L',
        defaultDate: tomorrow,
		useCurrent:false
	});
    $("#startDatePicker").on("change.datetimepicker", function (e) {
		$('#endDatePicker').datetimepicker('minDate', e.date);
	});
	$("#endDatePicker").on("change.datetimepicker", function (e) {
		$('#startDatePicker').datetimepicker('maxDate', e.date);
	});

	$('#startDatePicker').on('change.datetimepicker', function(e){ updateAnimation();});
	$('#endDatePicker').on('change.datetimepicker', function(e){ updateAnimation();});
}

$(function () {
    window['moment-range'].extendMoment(moment);

	$('[data-toggle="tooltip"]').tooltip({
		trigger : 'hover'
	});
	$('.popover-dismiss').popover({
		trigger: 'hover'
	});
	initCalendars();
    updateAnimation();
});

/**
 * This function gets the dates from the calendars,
 * creates an 'animation' object, and starts the animaion.
 */
function updateAnimation(){
    filterFromCalendars();
    var defaultNames = filterFromCalendars();
    delete goesAnimation;
	goesAnimation = new Animation(defaultNames, 'goes_canvas', 'goesAnimation');
	//Start loading the images and playing the animation. 
	// It starts with a height of 50% of the window size
	goesAnimation.init();
}

function toggledisplay(elementID)
{
	(function(style) {
		style.display = style.display === 'none' ? '' : 'none';
	})(document.getElementById(elementID).style);
}

image_type = "jpg";                   //"gif" or "jpg" or whatever your browser can display

first_image_name = 0;     //Representa el nombre de la primer imagen
first_image = 0;                      //first image number
speed_text = 0;
var inicioPlayfwd = false;    //Controla la animacion si esta en play o en stop
var inicioPlayBkw = false;    //Controla la animacion cuando esta en reversa

//=== THE CODE STARTS HERE - no need to change anything below ===
//=== global variables ====
var theImages = new Array();
normal_delay = 1000;
delay = normal_delay;  //delay between frames in 1/100 seconds
delay_step = 10;
delay_max = 30000;
delay_min = 1;
current_image = first_image;     //number of the current image
timeID = null;
status = 1;            // 0-stopped, 1-playing
play_mode = 1;         // 0-normal, 1-loop, 2-swing
size_valid = 0;
var loadCount = 1;
var last_image_;
var lewidth;
var leheight;

speed_text = 1;


function scalePreserveAspectRatio(imgW,imgH,maxW,maxH){
//	console.log(imgW,",",imgH,",",maxW,",",maxH);
    return(Math.min((maxW/imgW),(maxH/imgH)));
}

function naturalCompare(a, b) {
	var ax = [], bx = [];
	
	a.replace(/(\d+)|(\D+)/g, function(_, $1, $2) { ax.push([$1 || Infinity, $2 || ""]) });
	b.replace(/(\d+)|(\D+)/g, function(_, $1, $2) { bx.push([$1 || Infinity, $2 || ""]) });
	
	while(ax.length && bx.length) {
		var an = ax.shift();
		var bn = bx.shift();
		var nn = (an[0] - bn[0]) || an[1].localeCompare(bn[1]);
		if(nn) return nn;
	}
	
	return ax.length - bx.length;
}
