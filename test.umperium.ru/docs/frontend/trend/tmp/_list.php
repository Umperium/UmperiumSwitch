
<h5>Тренды:</h5>
<hr style="margin-top: 5px;">
<div style="text-align:center">
<?php $i=0; while ( $row = $RESULT->fetch() ) { $i++ ?>
<a href="/trend/<?php echo $row['slug']; ?>" class="btn btn-outline-<?php echo $i==1?'danger':'dark'?> waves-effect waves-light">#<?php echo $row['name']; ?></a>
<?php } ?>
</div>
