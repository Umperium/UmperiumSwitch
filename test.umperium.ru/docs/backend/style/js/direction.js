$(document).ready(function() {
	"use strict";

	try{ 
		
		$("#to_fake").autocomplete({
			source:'/backend/direction/?action=ajax',
			minLength: 2,
			items:1,
			select: function( event, ui ) {
				$("#to_city").val(ui.item.id);
			},
			response: function(event, ui) {
				if (ui.content.length === 0) {
					$("#to_city").val('');
				} 
			}
		});
		
	} catch(e) {
		alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
	}

});
