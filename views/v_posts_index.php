

<!-- <legend> My Post Feed </legend> 
<?php foreach($posts as $post): ?>

	<strong>
		<?=$post['first_name']?> posted on <?=Time::display($post['created'])?>
	</strong>
	<br>
	<?=$post['content']?>
	<br>
	<br>
	
<?php endforeach; ?>
-->
<legend> My Post Feed </legend> 


<?php if ($following_cnt==0): ?>
	You aren't following anyone yet!
<?php elseif($following_cnt==1 & $num_of_posts==0): ?>
	The person you are following hasn't posted anything yet.
<?php elseif($following_cnt>1 & $num_of_posts==0): ?>
	The people you are following haven't posted anything yet.
<?php else: ?>
<table class="table striped">
<thead>
<tr>
	<th>Name</th>
	<th>Date</th>
	<th>Post</th>
</tr>
</thead>
<tbody>

	<?php foreach($posts as $post): ?>
	 <tr>
		<td><?= $post['first_name'] ?> </td>
		<td><?= Time::display($post['created']) ?></td>
		<td>
		 <?=$post['content']?>
		</td>
		
	 </tr>

	<?php endforeach ?>

</tbody>
</table>
<?php endif ?>
		