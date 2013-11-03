
<legend> <?=$user->first_name?>'s Profile!  </legend>

<?php if ($following_cnt==0): ?>
	You aren't following anyone yet!
<?php else: ?>
	You are following <?= $following_cnt ?> people.
<?php endif; ?>

<br>
<br>

<?php if ($post_cnt==0): ?>
	You you haven't posted yet!
<?php else: ?>
	You have <?= $post_cnt ?> post <?php if($post_cnt>1) echo "'s" ?>.
<?php endif; ?>
