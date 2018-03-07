(function($) {
	var template = null
	var onload = null
	var onerror = null
 
    var loadIt = function(data) {
    	url = data.url
    	params = data.params
        template = data.template
        onload = data.onload
        onerror = data.onError

        ajaxCall(data.url, data.urlParams);
    }

    function ajaxCall(url, params){
    	$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',	
			success: function(result){
				processData(result)
			},
			error: function(xhr, ajaxOptions, thrownError){
				error(xhr.responseText)
			}
		})
    }

    function processData(data){
    	if(onload){
    		data = onload(data)
    	}
    	console.log(data);
    }

    function error(message){
    	if(onerror){
    		onerror(message)
    	}
    	else{
	    	console.log(message)
	    }
    }

    $.fn.loadIt = loadIt

}(jQuery));


// $('#div').loadIt({
// 	url: 'base_url',
// 	urlParams: {

// 	},
// 	template: $('template'),
// 	onload: function(data){

// 	},

// });

