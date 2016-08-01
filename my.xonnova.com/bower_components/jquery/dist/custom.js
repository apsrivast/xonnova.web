$(document).ready(function() {
	$( "#datepicker" ).datepicker({
		formatSubmit: 'yyyy-mm-dd',
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: "1940:2050",
		selectYears: 100,
	});
});