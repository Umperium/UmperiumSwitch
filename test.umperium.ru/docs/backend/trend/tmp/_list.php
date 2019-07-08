<?php defined('_JEXEC') or die(); ?>
<div class="block">
	<table id="table" class="display">
		<thead>
			<tr>
				<th>Название</th>
				<th>Период</th>
				<th>Порядок</th>
				<th class="action"></th>
			</tr>
		</thead>
		<tbody>
			<?php while($row = $RESULT->fetch()) {?>
			<tr class="<?php echo $row['is_active']==1?'active':'no-active'; ?>"> 
				<td><a href="?action=edit&id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
				<td><?php echo $row['date_from']; ?> - <?php echo $row['date_to']; ?></td>
				<td><?php echo $row['sort']; ?></td>
				<td class="action">
					<a href="?action=is_active&id=<?php echo $row['id']; ?>" class="status"><i class="fa fa-check-square"></i></a>
					<a href="?action=delete&id=<?php echo $row['id']; ?>" class="delete" title="Удалить?"><i class="fa fa-trash-alt"></i></a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>