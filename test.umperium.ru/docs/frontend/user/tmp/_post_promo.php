<?php defined('_JEXEC') or die(); ?>
<table id="datatable" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
	<thead>
	<tr role="row"><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 128px;"><h5>Заголовок поста</h5></th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 74px;"><h5>Ставка (умп)</h5></th><th class="sorting_desc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" aria-sort="descending" style="width: 94px;"><h5>Дата </h5></th></tr>
	</thead>
	<tbody>
	<?php while($row = $RESULT->fetch()) { ?>
	<tr role="row" class="odd">
		<td class=""><a href="/post/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a></td>
		<td><div class="umpval"><?php echo $row['score']; ?></div></td>
		<td class="sorting_1"><?php echo date("d/m/Y - H:i", strtotime($row['published']) ); ?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>



