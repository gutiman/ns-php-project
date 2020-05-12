$(document).foundation();

function calloutMsj(type, header, content, keepOpen) {
    // Create a callout or alert with the result of the AJAX call
    var sCallout = '';

    if(type !== 'empty') {
        // take advantage of the callout class in Foundation
        sCallout +=
            '<div class="callout ' + type + '" data-closable="slide-out-right">' +
                '<h5><strong>' + header + '</strong></h5>' +
                '<p>' + content + '</p>';

        // In case we want to make the callout closable
        if(typeof keepOpen === 'undefined' || keepOpen === false) {
            sCallout += 
                '<button class="close-button" aria-label="Dismiss alert" type="button" data-close>' + 
                    '<span aria-hidden="true">&times;</span>' + 
                '</button>';
        }
        
        sCallout += '</div>';
    }

    $('#callout').html(sCallout);
}

function formQueryToJSON(urlparams) {
	'use strict';
	
	// Separate all the pairs var=val
	var sParams = urlparams.replace(/\+/g, ' ');
	var aParams = sParams.split('&');
	
	var oParams = {};
	// for each pair of var and val
	aParams.forEach(function(pair) {
		// Separate them by the equal =
		var pair = pair.split('=');
		if(oParams.hasOwnProperty(pair[0])) {
		   	if($.isArray(oParams[pair[0]])) {
				oParams[pair[0]].push(pair[1]);
			}
			else {
				var current = oParams[pair[0]];
		   		oParams[pair[0]] = [];
				oParams[pair[0]].push(current);
				oParams[pair[0]].push(pair[1]);
			}
		}
		else {
			// Put the variable in the object equal to its value
			oParams[pair[0]] = decodeURIComponent(pair[1] || '');
		}
	});
	
	$.each(oParams, function(key) {
		if($.isArray(oParams[key])) {
			oParams[key] = oParams[key].join(',');
		}
	});
	
	// convert to JSON and then back again to be sure the object is correct and valid
	oParams = JSON.parse(JSON.stringify(oParams));
	
	return oParams;
}