<?php defined('_JEXEC') or die(); ?>
<div class="block">
	<table id="table" class="display">
		<thead>
			<tr>
				<th>Название</th>
				<th>Транслит</th>
				<th>Значение</th>
			</tr>
		</thead>
		<tbody>
			<?php while($row = $RESULT->fetch()) {?>
			<tr class="active"> 
				<td><a href="?action=edit&id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
				<td><?php echo $row['slug']; ?></td>
				<td><?php echo $row['value']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>