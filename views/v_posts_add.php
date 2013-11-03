<form method='post' action='/posts/p_add'>

	<legend> Post </legend>
	<textarea name='content' class='xxlarge'></textarea>
	
	<br><br>
	
	<input type='Submit' value='Add new post' class="btn">

</form>

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

	 </tr>

	<?php endforeach ?>

</tbody>
</table>
<?php endif ?>
<br><br>