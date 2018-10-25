var inicializarControles=function()
	{
  	 $("#fecha").datepicker({
 		yearRange : "1990:2020",
 		changeYear : true,
 		changeMonth : true,
 		constrainInput : true
 	});
	}
     $(document).ready(function(){inicializarControles()});