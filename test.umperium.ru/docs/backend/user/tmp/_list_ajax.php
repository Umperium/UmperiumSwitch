<?php defined('_JEXEC') or die(); ?>
<div class="block">

	<table id="table-ajax" class="display">
		<thead>
			<tr>
				<th>Пользователь</a></th>
				<th>E-mail</th>
				<th>Страна</th>
				<th>Город</th>
				<th>Пол</th>
				<th>Счет</th>
				<th>Действие</th>
			</tr>
		</thead>
	</table>
	
</div>


<script>
$(document).ready(function() {
	"use strict";
	try{ 
		$('#table-ajax').DataTable({
			"stateSave": true,
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
			},
			
			"processing": true,
			"serverSide": true,
			"serverMethod": 'post',
			"ajax": {
				"url":'/backend/user/?action=ajax_list'
			},

			"columns": [
				{ data: 'name' },
				{ data: 'email' },
				{ data: 'country' },
				{ data: 'city' },
				{ data: 'sex', "orderable": false },
				{ data: 'score' },
				{ data: 'action', "orderable": false, "class": 'action' },
			]
		});

	} catch(e) { }
});
</script>