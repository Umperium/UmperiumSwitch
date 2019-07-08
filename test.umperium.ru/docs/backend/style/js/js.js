$(document).ready(function() {
	"use strict";
	
	/* MOBILE MENU */
	try{ 
		$(".trigger-aside").click(function(event){
			event.preventDefault();
			$("#aside").toggleClass("active");
		});
	} catch(e) {
		alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
	}
	
	/* POP */
	try{ 
		$( "body" ).on( "click", ".pop", function(event) {
			event.preventDefault();
			$($(this).attr("href")).show();
			return false;
		});

		$( "body" ).on( "click", ".pop-overlay .overlay", function(event) {
			event.preventDefault();
			$(".pop-overlay").hide();
			return false;
		});
		
		$( ".pop-overlay.limit" ).delay(1000).fadeOut(300,function(){ $(this).remove(); });
		
	} catch(e) {
		alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
	}
	
	/* DATAPICKER */
	try{ 
		$.datepicker.regional['ru'] = {
			closeText: 'Закрыть',
			prevText: '<Пред',
			nextText: 'След>',
			currentText: 'Сегодня',
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
			monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
			'Июл','Авг','Сен','Окт','Ноя','Дек'],
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
			dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
			dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			weekHeader: 'Не',
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['ru']);
		
		$.timepicker.regional['ru'] = {
			timeOnlyTitle: 'Выберите время',
			timeText: 'Время',
			hourText: 'Часы',
			minuteText: 'Минуты',
			secondText: 'Секунды',
			millisecText: 'Миллисекунды',
			timezoneText: 'Часовой пояс',
			currentText: 'Сейчас',
			closeText: 'Закрыть',
			timeFormat: 'HH:mm',
			amNames: ['AM', 'A'],
			pmNames: ['PM', 'P'],
			isRTL: false
		};
		$.timepicker.setDefaults($.timepicker.regional['ru']);
	} catch(e) { }	
		
	try{ 	
		$('.date-input').datepicker({
			dateFormat : 'yy-mm-dd'
		});
		
		$('.date-input.today').datepicker({
			dateFormat : 'yy-mm-dd',
			minDate: 0
		});
		
		$('.date-time-input').datetimepicker({
			dateFormat : 'yy-mm-dd',
			timeFormat: 'HH:mm:ss',
		});
		
		$('.date-time-input.today').datetimepicker({
			dateFormat : 'yy-mm-dd',
			timeFormat: 'HH:mm:ss',
			minDate: 0
		});
	} catch(e) { }
	
	/* TABLE */
	try{ 

		$('#table').DataTable({
			stateSave: true,
			"language": {
				"processing": "Подождите...",
				"lengthMenu": "Показать _MENU_ записей на странице",
				"zeroRecords": "Ничего не найдено",
				"info": "страница _PAGE_ из _PAGES_",
				"infoEmpty": "Нет доступных записей",
				"infoFiltered": "(отфильтровано из _MAX_ записей)",
				"emptyTable": "В таблице отсутствуют данные",
				"search": "Поиск:",
				"paginate": {
					"first": "Первая",
					"last": "Последняя",
					"next": "Следующая",
					"previous": "Предыдущая"
				}
			}
		});

	} catch(e) { }
	
	try{ 

		$('#export-table').DataTable({
			dom: 'Bfrtip',
			stateSave: true,
			lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10 записей', '25 записей', '50 записей', 'Все' ]
			],
			pageLength: 5,
			buttons: [
				{
					extend: 'copyHtml5',
					text: '<i class="fa fa-copy"></i> Копировать'
				},{
					extend: 'print',
					text: '<i class="fa fa-print"></i> Печатать'
				},{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel"></i> Excel',
					titleAttr: 'Excel'
				},{
					extend:    'csvHtml5',
					text:      '<i class="fa fa-file-excel"></i> CSV',
					titleAttr: 'CSV'
				},{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf"></i> PDF',
					titleAttr: 'PDF'
				},{
					extend: 'pageLength',
					text: 'Показать'
				},
			],
			"language": {
				"processing": "Подождите...",
				"lengthMenu": "Показать _MENU_ записей на странице",
				"zeroRecords": "Ничего не найдено",
				"info": "страница _PAGE_ из _PAGES_",
				"infoEmpty": "Нет доступных записей",
				"infoFiltered": "(отфильтровано из _MAX_ записей)",
				"emptyTable": "В таблице отсутствуют данные",
				"search": "Поиск:",
				"paginate": {
					"first": "Первая",
					"last": "Последняя",
					"next": "Следующая",
					"previous": "Предыдущая"
				},
				 "buttons": {
					"pageLength": {
						_: "Показать %d записей",
						'-1': "Показать все"
					}
				}
			}
		});
	} catch(e) { }
	
	/* SORTABLE */
	try{

		$('#sortable-tree').nestedSortable({
			forcePlaceholderSize: true,
			opacity: 0.7,
			handle: 'div',
			items: 'li',
			placeholder: 'placeholder',
			tolerance: 'pointer',
			toleranceElement: '> div',
			isTree: true
		});

		$('#sortable').nestedSortable({
			forcePlaceholderSize: true,
			opacity: 0.7,
			handle: 'div',
			items: 'li',
			placeholder: 'placeholder',
			tolerance: 'pointer',
			toleranceElement: '> div',
			isTree: false,
			maxLevels: 1
		});

		$( "body" ).on( "click", "#serialize", function(event) {
			event.preventDefault();
			var serialized = $('ol.sortable').nestedSortable('serialize');
			$.get("", serialized );
		});
	} catch(e) { }
	
	/* TAB */
	$( "body" ).on( "click", ".tab-control a", function(event) {
		event.preventDefault();
		$(".tab-control a").removeClass("active");
		$(this).addClass("active");
		
		var tab = $(this).attr("href");
		$(".tab-item").removeClass("active");
		$(tab).addClass("active");
		return false;
	});
	
	
});