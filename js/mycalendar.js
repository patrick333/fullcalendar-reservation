if (!_ED_) {
	var _ED_={TPL:{}};
}
_ED_.uid=1;
_ED_.modifyMode=false;
_ED_.modifyEid=0;
_ED_.bizHours=[9,10,11,14,15,16,17];

$(document).ready(function() {
	var _INV_= setInterval(function() {
	if (!_ED_| _ED_.now=='undefined') {
		return false;
	}
	clearInterval(_INV_);
	_ED_.init();	
	}, 100);


	_ED_.init=function(){
		_ED_.loadEvents();
		// console.log("in init()");
	};

	_ED_.loadEvents=function(){
		$.ajax({
		    url: 'service/events/fetchEvents.php',
		    data: {},
		    dataType: 'jsonp',   
		    jsonpCallback: '_ED_.loadCalendar'
		});

		return;
	};

	_ED_.loadCalendar=function(data){
		console.log(data);
		if(data.status!="FAIL"){
			// console.log(data.events);
			_ED_.events=data.events;
			_ED_.now=new Date();

			$('#calendar').fullCalendar({
				theme: true,
				eventStartEditable:false,
				eventDurationEditable:false,
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay',
				},
				defaultView:'agendaWeek',
				businessHours: {
					start:'9:00',
					end:'18:00',
					// dow:[1,2,3,4]
				},
				defaultDate:_ED_.now,
				eventLimit: true, // allow "more" link when too many events
				events: _ED_.events,

				dayClick:_ED_.dayClick,
				eventClick:_ED_.eventClick,

				loading: function(bool) {
					console.log('loading...');
				}
			});
			// end of calendar
		}
		// end of if	
	};

	_ED_.dayClick=function(date, jsEvent, view){
		// console.log('Clicked on: ' + date.format());
  //       console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
  //       console.log('Current view: ' + view.name); //month, agendaWeek, or agendaDay. 
  //       $(this).css('background-color', 'red');

  		if(_ED_.uid!=''){//CAN ADD EVENTS
			var availHours=fetchAvailHoursForADay(date.format('YYYY-M-D'),_ED_.bizHours);
			var data={date:date.format("dddd, MMMM Do YYYY"),availHours:availHours, modifyMode:_ED_.modifyMode};
			_ED_.reserve(data);
  		}
	}

	_ED_.eventClick=function(calEvent, jsEvent, view){	
		// console.log(calEvent);
		// console.log('Event: ' + calEvent.title);
  //       console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
  //       console.log('Current view: ' + view.name); //month, agendaWeek, or agendaDay. 
  //       $(this).css('background-color', 'red');

  		if(_ED_.uid!=''){//CAN ENTER MODIFY MODE
  			if(_ED_.modifyMode==true){//already in modify mode
  				if(calEvent.eid==_ED_.modifyEid){//cancel the modify mode
  					_ED_.modifyMode=!_ED_.modifyMode;
	  				_ED_.modifyEid=0;
  					$(this).removeClass('selected');
  				}
  			}
  			else{//not yet in modify mode
  				_ED_.modifyMode=!_ED_.modifyMode;
  				_ED_.modifyEid=calEvent.eid;
  				$(this).addClass('selected');	
  			}
  		}
	}

	_ED_.reserve=function(data){
		var newEvent = new jSmart(_ED_.TPL.newEvent_tpl);
		$('#Modal_Body').html(newEvent.fetch(data));				
		$('#ED_Modal').modal('show');	
	}

	_ED_.reserveSubmit=function(o,dateStr){
		var form_data=$(o).parents("form:first").serializeArray();
		var fdata = {};
		for (i=0; i<form_data.length; i++) {
			fdata[form_data[i]['name']] = form_data[i]['value'];
		}

		//modify the db, and refrech calendar. 
		var tempDate=new moment(dateStr, 'dddd, MMMM Do YYYY');
		var date=tempDate.format('YYYY-M-D');
		var queryStr='&uid='+_ED_.uid+'&date='+date+'&start='+fdata['start']+'&modifyMode='+_ED_.modifyMode+'&modifyEid='+_ED_.modifyEid;
		// console.log(queryStr);

		if (!_ED_._SEARCH_) _ED_._SEARCH_ = {};
		var cd = new Date().getTime();
		
		_ED_._SEARCH_['C_'+cd] = function(data) {
			console.log(data);

			if(data.status!='SUCCESS'){//failed to reserve.
				fdata['error'] = data['error'];
				_ED_.reserve(fdata);
			}
			else{
				if(_ED_.modifyMode){
					fdata['success'] = 'Your session has been rescheduled. Calendar refreshing...';
				}
				else{
					fdata['success'] = 'Your session has been reserved. Calendar refreshing...';
				}
				_ED_.reserve(fdata);

				setTimeout(function() { 
					$('#ED_Modal').modal('hide');	

					if(_ED_.modifyMode){
						// for (i=0; i<_ED_.events.length; i++) {
						// 	if(_ED_.events[i].eid==_ED_.modifyEid){
						// 		_ED_.events.splice(i,1);	
						// 	}
						// }
						_ED_.modifyMode=false;
						_ED_.modifyEid=0;
						$('.selected').removeClass('selected');
					}
					// _ED_.events.push(data.newEvent);

					// $('#calendar').fullCalendar('renderEvent', data.newEvent, false); 		

					$('#calendar').fullCalendar('destroy');
					_ED_.loadEvents();			
				}, 1000);	
			}

			delete _ED_._SEARCH_['C_'+cd];
		};
		$.getScript('service/events/reserveEvent.php?callback=_ED_._SEARCH_.C_'+cd+queryStr,
			function( data) {});
	};



	






		
});