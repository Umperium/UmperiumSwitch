<?php defined('_JEXEC') or die(); ?>
<div class="block">
	<table id="table" class="display">
		<thead>
			<tr>
				<th>Пост</th>
				<th>Кто пожаловался</th>
				<th>Причина</th>
				<th>Дата жалобы</th>
				<th class="action"></th>
			</tr>
		</thead>
		<tbody>
			<?php while($row = $RESULT->fetch()) {?>
			<tr class="<?php echo $row['is_active']==1?'active':'active'; ?>"> 
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['l_name']; ?> <?php echo $row['f_name']; ?></td>
				<td>
				<?php echo $row['cause']==1?'Фейковые новости':''; ?>
				<?php echo $row['cause']==2?'Пропаганда наркотиков':''; ?>
				<?php echo $row['cause']==3?'Терроризм':''; ?>
				<?php echo $row['cause']==4?'Материал для взрослых':''; ?>
				<?php echo $row['cause']==5?'Спам':''; ?>
				<?php echo $row['cause']==6?'Призыв к суициду':''; ?>
				<?php echo $row['cause']==7?'Мошенничество':''; ?>
				<?php echo $row['cause']==8?'Травля /Оскорбления':''; ?>
				<td><?php echo $row['published']; ?></td>
				<td class="action">
					<a href="?action=delete&id=<?php echo $row['id']; ?>" class="delete" title="Удалить?"><i class="fa fa-trash-alt"></i></a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>