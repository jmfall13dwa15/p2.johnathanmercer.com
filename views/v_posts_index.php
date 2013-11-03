

<legend> My Post Feed </legend>
<?php foreach($posts as $post): ?>

	<strong><?=$post['first_name']?> posted on <?=Time::display($post['created'])?></strong><br>
	<?=$post['content']?><br><br>
	
<?php endforeach; ?>

<?php if ($following_cnt==0): ?>
	You aren't following anyone yet!
<?php elseif($following_cnt==1 & $num_of_posts==0): ?>
	The person you are following hasn't posted anything yet.
<?php elseif($following_cnt>1 & $num_of_posts==0): ?>
	The people you are following haven't posted anything yet.
<?php endif ?>
		