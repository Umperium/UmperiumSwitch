<?php defined('_JEXEC') or die(); ?>
<table class="table table-striped">
	<thead class="thead-default">
	<tr>
		<th style="text-align: center;">#</th>
		<th style="text-align: center;"><h6>РАНГ</h6></th>
		<th></th>
		<th style="text-align: center;"><h6>МЫСЛИТЕЛЬ</h6></th>
		<th style="text-align: center;"><h6>ФЛАГ</h6></th>
		<th style="text-align: center;"><h6>СИЛА МЫСЛИ</h6></th>
		<th style="text-align: center;"><h6>КОММЕНТАРИИ</h6></th>
		<th style="text-align: center;"><h6>ИНФ.КАПИТАЛ</h6></th>
	</tr>
	</thead>
	<tbody>
	<?php $i=0; while($row = $RESULT->fetch()) {
		$i++;
		if(empty($row['image'])) { 
			$image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
		} else {
			$image = USER_UPLOADS.'/'.substr($row['image'],0,2).'/'.$row['image'];
		}
		$name = $row['l_name'].' '.$row['f_name'];

		$color  = '';
		if( $row['power']>0) { $color = 'color:#00a500'; } 
		if( $row['power']<0) { $color = 'color:#ff4c6c'; } 
	?>
	<tr>
	<th scope="row"><h6><?php echo $i; ?></h6></th>
	<td><a href="/user/<?php echo $row['id']; ?>"><img style="height:45px; width:45px; " src="<?php echo FRONTEND_PATH; ?>/images/BRAINRANK1.png" alt="user"></a></td>
	<td><a href="/user/<?php echo $row['id']; ?>"><img style="height:40px; width:40px; border-radius:50% !important; " src="/classes/thumb.php?src=<?php echo $image; ?>&amp;h=200&amp;w=200&amp;zc=1" alt="user"></a></td>
	<td>
	<a href="/user/<?php echo $row['id']; ?>">
		<span class="badge badge-danger"><?php echo $name; ?></span>
	</a>
	</td>
	<td><img src="<?php echo FRONTEND_PATH; ?>/images/flags/<?php echo $row['code']; ?>.png"  height="20" alt=""></td>
	<td style="<?php echo $color; ?>"><?php echo $row['power']; ?></td>
	<td><?php echo $row['comment']; ?></td>
	<td><h5><?php echo $row['capital']; ?></h5></td>
	</tr>
	<?php } ?>
	</tbody>
</table>