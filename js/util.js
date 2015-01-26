
function dateStrFromDate(date){
	// var getClassOf = Function.prototype.call.bind(Object.prototype.toString);    
	//eg. getClassOf(new Date()); -> [object Date] 

	if( (typeof date=='object') && (date instanceof Date) ){
		var fullYear=date.getFullYear(),
		month=date.getMonth()+1,
		day=date.getDate();

		var dateStr=fullYear+'-'+month+'-'+day;
		return dateStr;
	}
	else{
		console.log("Error, "+date+" is not a Date instance in dateStrFromDate()");
	}

}

function hourFromDate(date){
	var getClassOf = Function.prototype.call.bind(Object.prototype.toString);   
	if(getClassOf(date)=='[object Date]'){
		return date.getHours();
	}
	else{
		console.log("Error, "+date+" is not a Date instance in hourFromDate()");
	}
}


function dateOutput(date){
	var getClassOf = Function.prototype.call.bind(Object.prototype.toString);   
	if(getClassOf(date)=='[object Date]'){
		var fullYear=date.getFullYear(),
		month=date.getMonth()+1,
		day=date.getDate(),
		hour=date.getHours(),
		minute=date.getMinutes(),
		second=date.getSeconds();

		var dateStr=fullYear+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
		return dateStr;
	}
	else{
		console.log("Error, "+date+" is not a Date instance in dateOutput()");
	}

}

function fetchAvailHoursForADay(dateStr, bizHours){
	var availHours=bizHours;
	for (var i = 0; i < _ED_.events.length; i++) {
		var eventStartDateType=new Date(_ED_.events[i].start);
		var eventDateStr=dateStrFromDate(eventStartDateType);
		if(eventDateStr==dateStr){
			var eventHour=hourFromDate(eventStartDateType);
			console.log(eventHour);
			var index=availHours.indexOf(eventHour);
			if(index>-1){
				availHours.splice(index,1);
			}
		}
	}

	return availHours;
}


