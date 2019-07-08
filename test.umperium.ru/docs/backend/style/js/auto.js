$(document).ready(function() {
	"use strict";

	try{ 
		
		$("#driver_fake").autocomplete({
			source:'/backend/auto/?action=ajax',
			minLength: 2,
			items:1,
			select: function( event, ui ) {
				$("#driver_id").val(ui.item.id);
			},
			response: function(event, ui) {
				if (ui.content.length === 0) {
					$("#driver_id").val('');
				} 
			}
		});
		
	} catch(e) {
		alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
	}

});
