var showElement = function(element, visible) {
	visible ? element.show() : element.hide();
}

var highlightElement = function(element, highlight) {
	highlight ? element.css("border", "2px solid red") : element.css("border", "none");
}

var $j = jQuery.noConflict();
$j(document).ready(function (){
	
	$j("#wme-webinar-date").datepicker({dateFormat:"DD, MM dd, yy"});
	
	var notifyBox = $j("#time-change-notify");
	var startTimeChange = $j("#start-changed");
	var endTimeChange = $j("#end-changed");
	
	var startTimeInput = $j("#wme-webinar-start");
	var endTimeInput = $j("#wme-webinar-end");

  var notify = function(notification) {
	  notifyBox.text(notification);
	  showElement(notifyBox, true);
  }
	
	startTimeInput.timepicker({
		timeFormat: "hh:mm TT",
		timeOnlyTitle: "Set Start Time",
		addSliderAccess: true,
		sliderAccessArgs: { touchonly: false },
		onClose: function(timeText, inst) {
			  highlightElement(startTimeChange, false);
				if (endTimeInput.val() != '') {
					var startTime = startTimeInput.datetimepicker('getDate');
					var endTime = endTimeInput.datetimepicker('getDate');
					if (startTime > endTime) {
						endTimeInput.datetimepicker('setDate', startTime);
						notify("Whoops! Your webinar may not start after the end time you've chosen. This webinar's end time has been automatically adjusted. Please verify the change before saving.");
						highlightElement(endTimeChange, true);
					}
					else {
						showElement(notifyBox, false);
						highlightElement(endTimeChange, false);
					}
				}
				else {
					endTimeInput.val(timeText);
				}
			}
		});
		
	endTimeInput.timepicker({
		timeFormat: "hh:mm TT",
	  timeOnlyTitle: "Set End Time",
		addSliderAccess: true,
		sliderAccessArgs: { touchonly: false },
		onClose: function(dateText, inst) {
			  highlightElement(endTimeChange, false);
				if (startTimeInput.val() != '') {
					var startTime = startTimeInput.datetimepicker('getDate');
					var endTime = endTimeInput.datetimepicker('getDate');
					if (startTime > endTime) {
						startTimeInput.datetimepicker('setDate', endTime);
						notify("Whoops! Your webinar may not end before the start time you've chosen. This webinar's start time has been automatically adjusted. Please verify the change before saving.");
						highlightElement(startTimeChange, true);
					}
					else {
						showElement(notifyBox, false);
						highlightElement(startTimeChange, false);
					}
				}
				else {
					startTimeInput.val(dateText);
				}
			}
		});
		
	var e_timezone = $j("#wme-webinar-timezone");
	var timezone = e_timezone.val() == '' ? null : e_timezone.val();
	e_timezone.timepicker({
	  timeFormat: "z",
	  timezoneList: [
	    { value: 'UTC-12:00', label: 'UTC-12:00'},
			{ value: 'UTC-11:00', label: 'UTC-11:00'},
			{ value: 'UTC-10:00', label: 'UTC-10:00'},
			{ value: 'UTC-09:30', label: 'UTC-09:30'},
			{ value: 'UTC-09:00', label: 'UTC-09:00'},
			{ value: 'UTC-08:00', label: 'UTC-08:00'},
			{ value: 'UTC-07:00', label: 'UTC-07:00'},
			{ value: 'UTC-06:00', label: 'UTC-06:00'},
			{ value: 'UTC-05:00', label: 'UTC-05:00'},
			{ value: 'UTC-04:30', label: 'UTC-04:30'},
			{ value: 'UTC-04:00', label: 'UTC-04:00'},
			{ value: 'UTC-03:30', label: 'UTC-03:30'},
			{ value: 'UTC-03:00', label: 'UTC-03:00'},
			{ value: 'UTC-02:00', label: 'UTC-02:00'},
			{ value: 'UTC-01:00', label: 'UTC-01:00'},
			{ value: 'UTC±00:00', label: 'UTC±00:00'},
			{ value: 'UTC+01:00', label: 'UTC+01:00'},
			{ value: 'UTC+02:00', label: 'UTC+02:00'},
			{ value: 'UTC+03:00', label: 'UTC+03:00'},
			{ value: 'UTC+03:30', label: 'UTC+03:30'},
			{ value: 'UTC+04:00', label: 'UTC+04:00'},
			{ value: 'UTC+04:30', label: 'UTC+04:30'},
			{ value: 'UTC+05:00', label: 'UTC+05:00'},
			{ value: 'UTC+05:30', label: 'UTC+05:30'},
			{ value: 'UTC+05:45', label: 'UTC+05:45'},
			{ value: 'UTC+06:00', label: 'UTC+06:00'},
			{ value: 'UTC+06:30', label: 'UTC+06:30'},
			{ value: 'UTC+07:00', label: 'UTC+07:00'},
			{ value: 'UTC+08:00', label: 'UTC+08:00'},
			{ value: 'UTC+08:45', label: 'UTC+08:45'},
			{ value: 'UTC+09:00', label: 'UTC+09:00'},
			{ value: 'UTC+09:30', label: 'UTC+09:30'},
			{ value: 'UTC+10:00', label: 'UTC+10:00'},
			{ value: 'UTC+10:30', label: 'UTC+10:30'},
			{ value: 'UTC+11:00', label: 'UTC+11:00'},
			{ value: 'UTC+11:30', label: 'UTC+11:30'},
			{ value: 'UTC+12:00', label: 'UTC+12:00'},
			{ value: 'UTC+12:45', label: 'UTC+12:45'},
			{ value: 'UTC+13:00', label: 'UTC+13:00'},
			{ value: 'UTC+14:00', label: 'UTC+14:00'}
	  	],
	  timezone: timezone,
	  timeOnlyTitle: "Choose Time Zone",
	  showTime: false,
	  showButtonPanel: false
	});
});