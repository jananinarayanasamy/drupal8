(function ($) {
	Drupal.behaviors.showtime = {
	  attach: function (context, settings) {
	   startTime();
	  }	
	};
  })(jQuery);

  function checkTime(i) {
	if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	return i;
  }
  function startTime() {
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();

	var currTime = '';
	m = checkTime(m);
	s = checkTime(s);
	
	  currTime = 	h + ":" + m + ":" + s ; 
	
	jQuery("#display-time").html(currTime);
	var t = setTimeout(startTime, 1000);
	
	//return currTime;
  }