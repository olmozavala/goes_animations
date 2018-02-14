<html>
	<?php
	include("queries.php");
	?>
	<head>
		<!--JS-->
		<script src="js/jquery.min.js"></script>
		<script src="js/moment.min.js"></script>
		<!--<script src="js/popper.min.js"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/tempusdominus-bootstrap-4.min.js"></script>
		<script src="js/moment-range.min.js"></script>

		<!--CSS-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
		<link href="css/tempusdominus-bootstrap-4.min.css"rel="stylesheet"  />
		<link href="css/bootstrap.min.css" rel="stylesheet"/>
		<link href="css/main.css" rel="stylesheet" >
		<link href="css/animcontrols.css" rel="stylesheet" >
	</head>

	<body>

		<div class="container">
            <div class="row justify-content-center">
				<div class="col-lg-10 col-md-10 col-sm-12  col-xs-12 ">
					<span class="mycenter"></span>
					<canvas id="goes_canvas" width="100%" ></canvas>
				</div>        
			</div>
		</div>
		<div class="container">
            <div class="row justify-content-center">
				<div class="offset-lg-3 col-lg-6 offset-md-2 col-md-8 col-sm-12  col-xs-12 ">
					<?php
					$jsObj = 'goesAnimation'; //This name MUST be harcoded
					include 'animControls.php';
					?>
				</div>
			</div>
        </div>
		<div class="container-fluid">
            <div class="row justify-content-start">
				<div class="offset-lg-1 col-lg-3 offset-md-2 col-md-8 col-sm-12  col-xs-12 ">
					<?php
					include 'calendars.php';
					?>
				</div>
			</div>
		</div>

		<footer class="footer">
            <div class="container-fluid" >
                <div class="row"><!-- Hidden medium and up -->
                    <div class="offset-lg-3 col-lg-4 col-md-5 col-sm-6 col-xm-8"> <img src="img/lanot2.png"           class="nav_logo_min"></div>
                    <div class="            col-lg-2 col-md-2 col-sm-2 col-xm-1"> <img src="img/goes-r-page-logo.png" class="nav_logo_min"> </div>
                    <div class="            col-lg-1 col-md-1 col-sm-1 col-xm-1"> <img src="img/IG.png"               class="nav_logo_min"> </div>
                    <div class="            col-lg-1 col-md-1 col-sm-1 col-xm-1"> <img src="img/unam.png"             class="nav_logo_min"> </div>
                    <div class="            col-lg-1 col-md-1 col-sm-1 col-xm-1"> <img src="img/logo.png"             class="nav_logo_min"> </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12 "> By <a href="https://github.com/ixchelzg">M.S. Ixchel Zazueta</a>, 
						 <a href="https://www.atmosfera.unam.mx/ciencias-atmosfericas/modelos-climaticos/alejandro-aguilar-sierra">M. S. Alejandro Aguilar</a> 
					 and <a href="http://olmozavala.com">Ph.D. Olmo Zavala</a>, 2017</div>
                </div>
                <small class="text-muted">
					Note: NOAA's GOES-16 satellite has not been declared operational and its data are preliminary and undergoing testing. Users receiving these data through any dissemination means (including, but not limited to, PDA, GeoNetcast Americas, HRIT/EMWIN, and GOES Rebroadcast) assume all risk related to their use of GOES-16 data and NOAA disclaims any and all warranties, whether express or implied, including (without limitation) any implied warranties of merchantability or fitness for a particular purpose.
				</small>
			</div>
		</footer>

		<script > var img_names = <?php echo json_encode($img_names); ?>;</script>
		<script >
			//		console.log(img_names);
			//		console.log(last_image);
		</script>
		<script src="js/Tools.js"></script>
		<script src="js/Animation.js"></script>
		<script src="js/anima.js"></script>
	</body>
</html>
