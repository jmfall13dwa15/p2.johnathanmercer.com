<legend> List of Users </legend>
<table class="table striped">
<thead>
<tr>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Change Status</th>
</tr>
</thead>
<tbody>

	<?php foreach($users as $user): ?>
	 <tr>
		<td><?=$user['first_name']?> </td>
		<td><?=$user['last_name']?></td>
		<td>
		<?php if(isset($connections[$user['user_id']])): ?>
			<a href='/posts/unfollow/<?=$user['user_id']?>' class="btn">Unfollow</a>
		<?php else: ?>
			<a href='/posts/follow/<?=$user['user_id']?>' class="btn">Follow</a>
		<?php endif; ?>	
		</td>
		
	 </tr>

	<?php endforeach ?>

</tbody>
</table>
