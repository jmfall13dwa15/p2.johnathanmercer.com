<form method='post' action=
	  <?php if (isset($post_to_update)){ echo '/posts/p_update/'.$post_id_to_update ;}
	  		else{echo '/posts/p_add';}?> >

	<legend> Post </legend>
	<textarea name='content' class='xxlarge'><?php if (isset($post_to_update)){ echo $post_to_update;}?></textarea>
	
	<br><br>
	
	<input type='Submit' value=<?php if (isset($post_to_update)){ echo "Update";}else{echo "Add";}?> class="btn">

</form>

<?php if(isset($error)): ?>
<div class="row-fluid status-bar">
    <div class="span12">
        <div class="alert alert-error" <?php if(!isset($error)){ echo 'style = "display: none"';} ?> >
		<?php if(isset($error)){ echo $error;} ?>
        </div>
    </div>
</div>
<?php endif; ?>

<legend> My Posts </legend>
<?php if (count($my_posts)==0): ?>
	You don't have any posts yet!
<?php else: ?>
<table class="table striped">
<thead>
<tr>
	<th>Date</th>
	<th>Post</th>
	<th>Delete</th>
	<th>Update</th>
</tr>
</thead>
<tbody>

	<?php foreach($my_posts as $post): ?>
	 <tr>
		<td><?= Time::display($post['created']) ?></td>
		<td>
		 <?=$post['content']?>
		</td>
		<td>
		 <a href='/posts/delete/<?=$post['user_id']?>/<?=$post['post_id']?>' class="btn">Delete</a>
		</td>		
		<td>
		 <a href='/posts/add/<?=$post['post_id']?>' class="btn">Update</a>
		</td>
	 </tr>

	<?php endforeach ?>

</tbody>
</table>
<?php endif ?>
<br><br>