$(document).ready(function() {

	var types =        [{name: 'image', value: 'add a photo'}, 
				        {name: 'image', value: 'upload a photo'},
				        {name: 'image', value: 'put a photo'},
				        {name: 'image', value: 'post a photo'}],
		sources = 	   [{name: 'image', value: 'add a photo'}, 
					 	{name: 'image', value: 'upload a photo'},
					 	{name: 'image', value: 'put a photo'},
					 	{name: 'image', value: 'post a photo'}],
		destinations = [{name: 'image', value: 'add a photo'}, 
					    {name: 'image', value: 'upload a photo'},
					    {name: 'image', value: 'put a photo'},
					    {name: 'image', value: 'post a photo'}];
	
	$('#type').autoSuggest(types, {selectionLimit: 1});
	$('#source').autoSuggest(sources, {selectionLimit: 1});
	$('#destinations').autoSuggest(destinations);
});