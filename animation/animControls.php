    <!-- First Image -->
    <button type="button" id="<?=$jsObj?>go2prev" onClick="go2image('<?=$jsObj?>',0)" 
        class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Ir a la primera imagen" >
        <i class="material-icons" >skip_previous</i>
    </button>
    <!-- Reduce Speed-->
    <button type="button" id="<?=$jsObj?>btn_frwd" style="display: inline;" onClick="change_speed('<?=$jsObj?>',-1)" 
        class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Menor velocidad">
        <i class="material-icons" >fast_rewind</i>
    </button>
    <!-- Prev Frame-->
    <button type="button" id="<?=$jsObj?>btn_prev" style="display: none;" onClick="go2image('<?=$jsObj?>',<?=$jsObj?>.currImg - 1)"
        class="btn btn-light btn-custom"  data-toggle="tooltip" data-placement="bottom" title="Imagen anterior">
        <i class="material-icons" >navigate_before</i>
    </button>
    <!-- Pause -->
    <button type="button" id="<?=$jsObj?>btn_stop" style="display: inline;" onClick="stop('<?=$jsObj?>')" 
        class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Pausa">
        <i class="material-icons" >pause</i>
    </button>
    <!-- Play -->
    <button type="button" id="<?=$jsObj?>btn_play" style="display: none;" onClick="play('<?=$jsObj?>')" 
        class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Play">
        <i class="material-icons" >play_arrow</i>
    </button>
    <!-- Next Frame -->
    <button type="button" id="<?=$jsObj?>btn_next" style="display: none;" onClick="go2image('<?=$jsObj?>',<?=$jsObj?>.currImg + 1)" 
        class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Imagen siguiente">
        <i class="material-icons"  >navigate_next</i>
    </button>
    <!-- Increase Speed -->
    <button type="button" id="<?=$jsObj?>btn_ffwd" style="display: inline;" onClick="change_speed('<?=$jsObj?>',1)"
        class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Mayor velocidad">
        <i class="material-icons"  >fast_forward</i>
    </button>
    <!-- Last Image-->
    <button type="button" id="<?=$jsObj?>go2next" onClick="go2image('<?=$jsObj?>',<?=$jsObj?>.totImgs-1)"
        class="btn btn-light btn-custom" data-toggle="tooltip" data-placement="bottom" title="Ir a la última imagen">
        <i class="material-icons"  >skip_next</i>
    </button>
    <!-- Show current frame-->
	<!--
    <label for="frame_nr" class="small">&nbsp;Imagen&nbsp;</label>  
        <INPUT TYPE="text" id="<?=$jsObj?>_frame_num" NAME="frame_nr" VALUE="0" style="width: 42px;" 
        class="form-control form-control-sm" onChange="go2image('<?=$jsObj?>',parseInt(this.value))"/>
        <span class="small"> &nbsp;/<span id="<?=$jsObj?>_lastimage"></span>&nbsp;&nbsp;&nbsp; </span>
 -->
