/*!
 * anima.js
 *
 * Copyright © 2017 Centro de Ciencias de la Atmosfera, UNAM 
 * https://github.com/olmozavala/goes_animations
 */


$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger : 'hover'
    });
    $('.popover-dismiss').popover({
        trigger: 'hover'
    });

    var lastdate = date_from_filename(images_names[last_image]);
    var firstdate = add_days_to_date(lastdate, -7);
    set_first_image_from_date(firstdate);
    $.datepicker.setDefaults( $.datepicker.regional[ "es" ] );
    $( "#datefirstimage" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#datelastimage" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#datefirstimage" ).datepicker( "setDate", firstdate );
    $( "#datelastimage" ).datepicker( "setDate", lastdate );

    $.getJSON("storms.js", function(obj) {
        console.log(obj);
        $.each(obj, function(i, storm) {
            $("#storms").append("<option value=\"" + storm[1]+storm[2] + "\">" + storm[0] + "</option>");
        });
    });

    images_names.sort(naturalCompare);
    launch();
});

function toggledisplay(elementID)
{
    (function(style) {
        style.display = style.display === 'none' ? '' : 'none';
    })(document.getElementById(elementID).style);
}

image_type = "jpg";                   //"gif" or "jpg" or whatever your browser can display
//      images_names = <?php echo json_encode($images); ?>;

first_image_name = 0;     //Representa el nombre de la primer imagen
first_image = 0;                      //first image number
//      last_image ="<?php echo $row_imagenes[0]-1; ?>";      //Representa el numero total de imagenes-1. Esto es, si last_image es 4 entonces en total son 5 imagenes
last_image = last_idx;
speed_text = 0;
var inicioPlayfwd = false;    //Controla la animacion si esta en play o en stop
var inicioPlayBkw = false;    //Controla la animacion cuando esta en reversa

//!!! the size is very important - if incorrect, browser tries to
//!!! resize the images and slows down significantly
animation_height = 680;              //height of the images in the animation
animation_width = 480;               //width of the images in the animation
//
//=== THE CODE STARTS HERE - no need to change anything below ===
//=== global variables ====
theImages = new Array();
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

//===> makes sure the first image number is not bigger than the last image number
if (first_image > last_image)
{
    var help = last_image;
    last_image = first_image;
    first_image = help;
};

//===> Fuctions to change the dates

function date_from_filename(name) {
    // Verificar que name tiene el formato y longitud apropiadas.
    // De acuerdo a formato images/Mexico_2017.0825.194536.goes-16_C13_2km.jpg
    var yy = 14;
    var mm = yy + 5;
    var dd = mm + 2;
    var year = name.slice(yy, yy+4);
    var month = name.slice(mm, mm+2);
    var day = name.slice(dd, dd+2);
    return [year, month, day].join('-');
}

function idx_from_date(date) {
    for (var i = 0; i <= last_idx; i++) {  
        datei = date_from_filename(images_names[i]);
        if (datei >= date) {
            return i;
        }
    }
    return last_idx;
}

function set_first_image_from_date(date) {
    first_image = idx_from_date(date);
    current_image = first_image;
    if (first_image > last_image) {
	last_image = first_image;
    }
}

function set_last_image_from_date(date) {       
    last_image = idx_from_date(date);
    if (first_image > last_image) {
	first_image = last_image;
    }
}

function format_Date_as_ISO8601(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function add_days_to_date(date, days) {
    var myDate = new Date(date);
    myDate.setDate(myDate.getDate() + days);
    return format_Date_as_ISO8601(myDate);
}

function set_dates_from_storm(value) {
    var firstdate = value.slice(0, 10);
    var lastdate = value.slice(10,20);
//    alert("Storm :" + firstdate + ":" + lastdate + ":");
    set_first_image_from_date(firstdate);
    set_last_image_from_date(lastdate);  
    $( "#datefirstimage" ).datepicker( "setDate", firstdate );
    $( "#datelastimage" ).datepicker( "setDate", lastdate );
}



function draw_slide(image){
    document.getElementById('animation').src = image.src;
    document.control_form.frame_nr.value = current_image;        
}

//===> displays image depending on the play mode in forward direction
function animate_fwd()
{
    current_image++;   
    if(current_image > last_image)
    {
        if (play_mode == 0)
        {
            current_image = last_image;
            status=0;
            return;
        };                           //NORMAL
        if (play_mode == 1)
        {
            current_image = first_image; //LOOP
        };      
    };   
    //document.animation.src = theImages[current_image].src;
    // Drawing the default version of the image on the canvas:
    draw_slide(theImages[current_image]);
    document.control_form.frame_nr.value = current_image+1;
    timeID = setTimeout("animate_fwd()", delay);
    //window.alert("Estoy en animate_fwd el ID es:"+timeID);  
}

//===> displays image depending on the play mode in reverse direction
function animate_rev()
{
    current_image--;
    if(current_image < first_image)
    {
        if (play_mode == 0)
        {
            current_image = first_image;
            status=0;
            return;
        };                           //NORMAL
        if (play_mode == 1)
        {
            current_image = last_image; //LOOP
        };      
    };   
         
    draw_slide(theImages[current_image]);
    document.control_form.frame_nr.value = current_image+1;
    timeID = setTimeout("animate_rev()", delay);
    //window.alert("Estoy en animate_bkw el ID es:"+timeID);        
}

//===> changes playing speed by adding to or substracting from the delay between frames
function change_speed(dv)
{
    if(dv<0)//Esta alreves porque se esta dividiendo el valor  mientras mas grande tons mas chico y asi
        speed_text++;
    else
        speed_text--;
    document.control_form.speed.value = speed_text;
    
    delay+=dv;
    if(delay > delay_max) delay = delay_max;
    if(delay < delay_min) delay = delay_min;
}

//===> stop the movie
function stop()
{       
    //window.alert("Estoy en stop borrando el ID:"+timeID);
    clearTimeout(timeID);       
    toggledisplay('btn_play');
    toggledisplay('btn_stop');
    toggledisplay('btn_ffwd');
    toggledisplay('btn_frwd');
    toggledisplay('btn_next');
    toggledisplay('btn_prev');          
    toggledisplay('btn_rev');   
    status = 0;
}

//===> "play forward"
function fwd()
{
    stop();
    status = 1;
    animate_fwd();
}

//===> jumps to a given image number
function go2image(number)
{
    //stop();
    //window.alert(number);
    if (number > last_image){
        number = first_image;
    }
    if (number < first_image){
        number = last_image;
    }
    current_image = number;
    //document.animation.src = theImages[current_image].src;
    draw_slide(theImages[current_image]);
    document.control_form.frame_nr.value = parseInt(current_image)+1;
}

//===> "play reverse"
toggleRev = 1;
function rev()
{
    //stop();
    var element = document.getElementById("btn_rev");
    element.classList.toggle("btn_rev_pressed");
    clearTimeout(timeID);
    status = 1;
    
    if(toggleRev == 1){
        animate_rev();
        document.getElementById("btn_rev").onclick = animate_fwd;
        toggleRev++;
    } else {
        animate_fwd();
        document.getElementById("btn_rev").onclick = rev;
        toggleRev--;
    }
    
}

//===> changes play mode (normal, loop, swing)
function change_mode(mode)
{
    play_mode = mode;
}
      
var terminoDeCargar = false;
var ultimaImagenCargada = 0;

function initImages(){
    console.log(images_names);
    for (var i = 0; i <= last_image; i++){  
	
        theImages[i] = new Image();
        
        theImages[i].src = images_names[i];
        theImages[i].onload = imagesloaded;
        
        current_image=i;
        document.control_form.frame_nr.value = current_image+1;
    }
}

var items = [/*...*/];
//called after each image is loaded and when all images are loaded, starts the show
function imagesloaded() {
    if (loadCount == last_image) {
        terminoDeCargar = true;
        toggledisplay('loader');
        toggledisplay('animation');
        //console.log('termino.');
        //launch();
    }
    loadCount++;
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

//===> sets everything once the whole page and the images are loaded (onLoad handler in <body>)
function launch()
{    
    if(!terminoDeCargar){
        initImages();
    } 
    document.getElementById('lastimage').innerHTML = theImages.length;
    
    fwd();   
    
    current_image = first_image;      
    document.control_form.speed.value = speed_text;
    // Drawing the default version of the image on the canvas:
    draw_slide(theImages[current_image]);
    
}
