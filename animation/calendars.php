<form>
	<!--Animation Speed-->
    <div class="form-group row">
		<label id="<?=$jsObj?>_speed_container" class="col-sm-12 col-form-label">
			Animation speed: <span id="<?=$jsObj?>_speed"> </span> &nbsp;(f/s)&nbsp;
		</label >
	   <!--Calendars-->
	</div>
	<div class="form-group row">
        <label for="startDatePicker" class="col-4 col-form-label">Start Date: </label> 
        <div class="input-group date col-8" id="startDatePicker" data-target-input="nearest">
            <input  id="startDate" type="text" class="form-control datetimepicker-input" data-target="#startDatePicker" style="width:110px"/>
                <div class="input-group-append" data-target="#startDatePicker" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
        </div>
	</div>
	<div class="form-group row">
        <label for="startDatePicker" class="col-4 col-form-label">End Date: </label> 
        <div class="input-group date col-8" id="endDatePicker" data-target-input="nearest">
            <input id="endDate" type="text" class="form-control datetimepicker-input" data-target="#endDatePicker" style="width:110px"/>
                <div class="input-group-append" data-target="#endDatePicker" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
        </div>
    </div><!-- Form Group --> 
</form>              
