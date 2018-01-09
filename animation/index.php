<html>
  <?php
    include("queries.php");
  ?>
  <head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
  </head>
  
  <body>
  
  <div class="container">
    
    <div class="card mb-3">
          
          <!-- the animation -->
          <div class="loader" id="loader" style="display: block;"></div>
          <img id="animation" class="card-img-top img-fluid no-padding" style="display: none;">
          
          <!-- the controls for the animation -->
          <div class="card-body">
            <FORM Method="POST" Name="control_form" class="form-inline form-horizontal col-centered">
              
            <button type="button" onClick="go2image(first_image)" class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Ir a la primera imagen" >
              <i class="material-icons" >skip_previous</i>
            </button>
            <button type="button" id="btn_frwd" style="display: none;" onClick="change_speed(100)" class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Menor velocidad">
              <i class="material-icons" >fast_rewind</i>
            </button>
            <button type="button" id="btn_rev" style="display: none;" onClick="rev()" class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Reversa">
              <i class="material-icons" >replay</i>
            </button>
            <button type="button" id="btn_prev" style="display: inline;" onClick="go2image(--current_image)" class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Imagen anterior">
              <i class="material-icons" >navigate_before</i>
            </button>
            <button type="button" id="btn_stop" style="display: none;" onClick="stop()" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Pausa">
              <i class="material-icons" >pause</i>
            </button>

            <button type="button" id="btn_play" style="display: inline;" onClick="fwd()" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Play">
              <i class="material-icons" >play_arrow</i>
            </button>
            

            <button type="button" id="btn_next" style="display: inline;" onClick="go2image(++current_image)" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Imagen siguiente">
              <i class="material-icons"  >navigate_next</i>
            </button>
            <button type="button" id="btn_ffwd" style="display: none;" onClick="change_speed(-100)" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Mayor velocidad">
              <i class="material-icons"  >fast_forward</i>
            </button>
            <button type="button" onClick="go2image(last_image)" class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Ir a la última imagen">
              <i class="material-icons"  >skip_next</i>
            </button>
            
            <label for="frame_nr" class="small">&nbsp;Imagen&nbsp;</label>  
            <INPUT TYPE="text" NAME="frame_nr" VALUE="0" style="width: 42px;" class="form-control form-control-sm" onChange="go2image(parseInt(this.value))">
            <span class="small"> &nbsp;/<span id="lastimage"></span>&nbsp;&nbsp;&nbsp; </span>
            

            <label for="speed" class="small">&nbsp;Velocidad &nbsp; </label>
            <INPUT TYPE="text" NAME="speed" SIZE="2" class="form-control form-control-sm" style="width: 42px;" readonly="readonly" />

      <label for="datefirst" class="small">&nbsp;Fecha inicial &nbsp; </label>
            <input type="text" id="datefirstimage" name="datefirstimage"
       class="form-control form-control-sm"
                   onChange="set_first_image_from_date(this.value)" />
            &nbsp;&nbsp;
            <label for="datelast" class="small">&nbsp;Fecha final &nbsp; </label>
            <input type="text" id="datelastimage" name="datelastimage"
       class="form-control form-control-sm"
                   onChange="set_last_image_from_date(this.value)" />
            &nbsp;&nbsp;

      <label for="torments" class="small">&nbsp;Tormenta &nbsp; </label>
            <select name="storms" id="storms" class="small" onChange="set_dates_from_storm(this.value)">
              <option value="all">Todas</option>
            </select>


      
      
            </FORM>              
          </div>
    </div>


    <footer class="footer">
      
      <div class="d-flex justify-content-end" style="height: 65px;">

      <p class="mr-auto p-2">By <a href="https://github.com/ixchelzg">M.S. Ixchel Zazueta</a>, <a href="https://www.atmosfera.unam.mx/ciencias-atmosfericas/modelos-climaticos/alejandro-aguilar-sierra">M. S. Alejandro Aguilar</a> and <a href="http://olmozavala.com">Ph.D. Olmo Zavala</a>, 2017</p>
      
          <img src="img/goes-r-page-logo.png" class="nav_logo_min">
          <img src="img/IG.png" class="nav_logo_min">
          <img src="img/unam.png" class="nav_logo_min">
          <img src="img/logo.png" class="nav_logo_min">

      </div>

      <div class="mt-5">
        <small class="text-muted">
        Note: NOAA's GOES-16 satellite has not been declared operational and its data are preliminary and undergoing testing. Users receiving these data through any dissemination means (including, but not limited to, PDA, GeoNetcast Americas, HRIT/EMWIN, and GOES Rebroadcast) assume all risk related to their use of GOES-16 data and NOAA disclaims any and all warranties, whether express or implied, including (without limitation) any implied warranties of merchantability or fitness for a particular purpose.
        </small>
      </div>

    </footer>

  </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <script language="JavaScript">var images_names = <?php echo json_encode($images); ?>;</script>
    <script language="JavaScript">var last_idx = "<?php echo $row_imagenes[0]-1; ?>";</script>
    <script src="js/anima.js"></script>

  </body>
</html>
