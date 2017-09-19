<html>
  <?php
    include("queries.php");
  ?>
  <head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
  </head>
  
  <body>
  
  <div class="container">
    <div class="header clearfix">
      
      <!-- <h3 class="text-muted">GOES</h3> -->
      <div class="text-center">
        <img src="img/goes-r-page-logo.png" class="nav_logo" />
      </div>
      <div class="text-center">
        <img src="img/unam.png" class="nav_logo_min"  />
        <img src="img/logo.png" class="nav_logo_min"  />
      </div>
    </div>

    <div class="card mb-3">
      <!--div class="row">
          <div class="col"-->   
              <!-- the animation -->
              <img id="animation" class="card-img-top img-fluid">
              <!--br>
          </div>
      </div-->    
      
<!--       <div class="row marketing"> -->
          <div class="card-body">
            <FORM Method="POST" Name="control_form" class="form-inline form-horizontal col-centered">
              <button type="button" onClick="go2image(first_image)" class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Ir a la primera imagen" >
                <i class="material-icons" >skip_previous</i>
              </button>
              <button type="button" onClick="go2image(--current_image)" class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Imagen anterior">
                <i class="material-icons" >fast_rewind</i>
              </button>
              <button type="button" onClick="rev()" class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Rev">
                <i class="material-icons" >navigate_before</i>
              </button>
              <button type="button" onClick="stop()" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Pausa">
                <i class="material-icons" >pause</i>
              </button>
              <button type="button" onClick="fwd()" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Fwd">
                <i class="material-icons"  >navigate_next</i>
              </button>
              <button type="button" onClick="go2image(++current_image)" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Imagen siguiente">
                <i class="material-icons"  >fast_forward</i>
              </button>
              <button type="button" onClick="go2image(last_image)" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Ir a la última imagen">
                <i class="material-icons"  >skip_next</i>
              </button>
              &nbsp;&nbsp;
              <label for="frame_nr" class="small">&nbsp;Imagen&nbsp;</label>  
              <INPUT TYPE="text" NAME="frame_nr" VALUE="0" SIZE="2" class="form-control form-control-sm" onChange="go2image(parseInt(this.value))">
              <span class="small"> &nbsp;/<span id="lastimage"></span>&nbsp; </span>
              &nbsp;&nbsp;
              <button type="button" class="btn btn-light btn-custom" onClick="change_speed(100)" data-toggle="tooltip" data-placement="bottom" title="Menos velocidad">
                <i class="material-icons" >remove</i>
              </button>
              <button type="button" class="btn btn-light btn-custom" onClick="change_speed(-100)" data-toggle="tooltip" data-placement="bottom" title="Mas velocidad">
                <i class="material-icons" >add</i>
              </button>
              &nbsp;&nbsp;
              <label for="speed" class="small">&nbsp;Velocidad &nbsp; </label>
              <INPUT TYPE="text" NAME="speed" VALUE="0" SIZE="2" class="form-control form-control-sm" readonly="readonly" />
            </FORM>              
          </div>
    </div>


    <footer class="footer">
      <p>By <a href='https://www.atmosfera.unam.mx/ciencias-atmosfericas/modelos-climaticos/alejandro-aguilar-sierra'>M. S. Alejandro Aguilar</a>, <a href='http://olmozavala.com'>Ph.D. Olmo Zavala</a> and <a href="https://github.com/ixchelzg">M.S. Ixchel Zazueta</a>, 2017</p>
    </footer>

  </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <script language="JavaScript"> 
      $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('.popover-dismiss').popover({
          trigger: 'focus'
        });
        images_names.sort(naturalCompare);
        launch();
      });

      image_type = "jpg";                   //"gif" or "jpg" or whatever your browser can display
      images_names = <?php echo json_encode($images); ?>;

      first_image_name = 0;     //Representa el nombre de la primer imagen
      first_image = 0;                      //first image number
      last_image ="<?php echo $row_imagenes[0]-1; ?>";      //Representa el numero total de imagenes-1. Esto es, si last_image es 4 entonces en total son 5 imagenes
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

      //===> makes sure the first image number is not bigger than the last image number
      if (first_image > last_image)
      {
         var help = last_image;
         last_image = first_image;
         first_image = help;
      };

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
         stop();
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
      }

      //===> "play reverse"
      function rev()
      {
         stop();
         status = 1;
         animate_rev();
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
              // Drawing the default version of the image on the canvas:
        }
      }

      var items = [/*...*/];
      //called after each image is loaded and when all images are loaded, starts the show
      function imagesloaded() {
        if (last_image === loadCount) {
          terminoDeCargar = true;
          //console.log('termino.');
          launch();
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
        // Drawing the default version of the image on the canvas:
        draw_slide(theImages[current_image]);
        
      }
    </SCRIPT>

  </body>
</html>