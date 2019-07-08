$(document).ready(function() {
	"use strict";
	
	/* FEATURE */
	try{ 
		$(".feature").autocomplete({
			source:'/backend/good?action=ajax&field=good_feature',
			minLength: 2,
			items:1,
			select: function( event, ui ) {
				$("#airport").val(ui.item.label);
				$("#airport_id").val(ui.item.id);
			}
		});
	} catch(e) {
		alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
	}
	
	/* FEATURE */
	try{
		$( "body" ).on( "click", "#feature-list .btn", function(event) {
			event.preventDefault();
			
			var url = '/backend/good?action=ajax&field=good_feature';
			
			$.get(
				url,
				function (result) {
					if (result.good_feature === 'error') {
						return false;
					}
					else {
						var select = '<div class="field"><select name="good_feature_id[]">'; 
						$(result.good_feature).each(function() {
							select += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
						});
						select += '</select></div>';
						var value = '<div class="field"><label>Значение</label><input type="text" value="" name="good_feature_value[]" required></div>';
						
						$("#feature-list").prepend('<div class="addition-item">'+select+value+'</div>');
					}
				},
				"json"
			);
			return false;
		});
		
	} catch(e) {
		alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
	}
	
});
