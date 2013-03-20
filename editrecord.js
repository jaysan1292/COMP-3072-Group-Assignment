$(function(){
	$.fn.editable.defaults.mode = 'inline';
	$('#contact_number').editable({
		url: '',
		title: 'Contact Info:'
	});
	$('#email').editable({
		url: '',
		title: 'Email Address:'
	});
	// $('#department').editable({
	// 	url: '',
	// 	title: 'Department:'
	// });
	$('#department').editable({
		value: 4,    
		source: [
		{value: 1, text: 'T127'},
		{value: 2, text: 'T141'},
		{value: 3, text: 'Free-Agent'},
		{value: 4, text: 'Rockstar'}
		]
	});
	$('#courses').editable({
        value: [1,2,3,4],    
        source: [
              {value: 1, text: 'option1'},
              {value: 2, text: 'option2'},
              {value: 3, text: 'option3'},
              {value: 4, text: 'option4'}
           ]
    });
	$('#book_off_reason').editable({
        url: 'post.php',
        title: 'Enter comments',
        rows: 5
    });
    $('#date1').combodate({
    minYear: 2013,
    maxYear: 2050,
    });
	$('#date2').combodate({
    minYear: 2013,
    maxYear: 2050,
    }); 
});