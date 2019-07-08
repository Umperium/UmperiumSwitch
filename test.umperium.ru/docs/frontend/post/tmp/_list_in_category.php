<table class="table">
	<tbody>
	<?php  
	$i=0;
	while ( $row = $RESULT->fetch() ) { 
		$i++;
		if(empty($row['user_image'])) { 
			$user_image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
		} else {
			$user_image = USER_UPLOADS.'/'.substr($row['user_image'],0,2).'/'.$row['user_image'];
		}
		$user_name = $row['l_name'].' '.$row['f_name'];
	?>
	<tr>
		<th scope="row">
			<img style="height:60px; width: 60px; border-radius:50%!important;" src="<?php echo $user_image; ?>" alt="user">
		</th>
		<td>
			<h5><a href="/user/<?php echo $row['user_id']; ?>" style="color:#fff" ><?php echo $user_name; ?></a></h5>
			<a href="/post/<?php echo $row['slug']; ?>" style="color:#fff" ><?php echo Truncate($row['content'],55); ?></a>
			<svg style="margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17" id="reply" width="16" height="16"><g fill="currentColor" fill-rule="evenodd"><path d="M14.802.024H3.147C1.412.024 0 1.415 0 3.126v7.087c0 1.71 1.412 3.102 3.147 3.102h7.423l3.358 3.24a.75.75 0 0 0 1.27-.539V13.29c1.55-.192 2.75-1.5 2.75-3.077V3.126c0-1.71-1.41-3.102-3.146-3.102zm1.888 10.189c0 1.026-.847 1.861-1.888 1.861h-.233a.625.625 0 0 0-.629.62v2.188l-2.664-2.626a.634.634 0 0 0-.445-.182H3.147c-1.041 0-1.888-.835-1.888-1.861V3.126c0-1.026.847-1.861 1.888-1.861h11.655c1.041 0 1.888.835 1.888 1.86v7.088z"></path><path d="M13.607 4.417H4.342a.625.625 0 0 0-.63.62c0 .343.283.62.63.62h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62zm0 3.474H4.342a.625.625 0 0 0-.63.62c0 .344.283.621.63.621h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62z"></path></g></svg>&nbsp;<?php echo $row['comment']; ?>
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>