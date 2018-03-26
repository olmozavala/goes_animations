/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Function used to filter names
function filterNames(names, filter){
	var res=[];
	for(var i =0; i < names.length;i++){
		if (names[i].includes(filter)){
			res.push(names[i]);
		}
	}
	return res;
}

//function filterFromCalendars(img_names, startDate, endDate){
function filterFromCalendars(){
    var startDate = $("#startDatePicker").datetimepicker('date');
    var endDate = $("#endDatePicker").datetimepicker('date');

    var range = moment.range(startDate, endDate);
    var fileNames = [];
    for (let day of range.by('day')){
        var tempNames = filterNames(img_names, day.format('YYYY.MMDD'));
        fileNames = fileNames.concat(tempNames);
    }
    console.log(fileNames);
    return fileNames;
}
