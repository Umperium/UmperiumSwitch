<?php
if(empty($row['image'])) { 
	$image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
} else {
	$image = GROUP_UPLOADS.'/'.substr($row['image'],0,2).'/'.$row['image'];
}
$name = $row['name'];
?>
<div class="card">
	<div class="headerinfo" style="text-align:center;">

		<div class="row">
			<div class="col-12">
			<div><img  src="/classes/thumb.php?src=<?php echo $image; ?>&amp;h=200&amp;w=200&amp;zc=1" alt="<?php echo $name; ?>" /></div>
			<?php if(in_array($_SESSION['user']->id,$array_subscribe)) { ?>
			<br>
			<button type="button" class="btn-xs btn-dark waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">
				Изменить
			</button>
			<?php } ?>
			<h4 style="text-align:center;"><?php echo $name; ?></h4>

			</div>
		</div>


	</div>

	<div class="card-body text-center mod-font-size">
		<?php if(isset($_SESSION['user']) && $_SESSION['user']!=$row['id']) { ?>
		<a href="#" id="alertify-subscribe" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $name; ?>" data-subscribe="<?php echo $_SESSION['user']->id; ?>">Подписаться</a>
		<?php } ?>
	</div>

</div>