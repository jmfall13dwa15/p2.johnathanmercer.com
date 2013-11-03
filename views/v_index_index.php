
<?php if($user): ?>
	<h2> Welcome <?php echo $user->first_name; ?>!</h2>
<?php else: ?>
<div class="home-hero">
    <h2> Welcome to MercMicro Blog </h2>
    <h4> Because the world needs another blog ... Ba!  </h4>

    <div style="opacity: .9;">
        <a class="btn btn-large" href="/users/signup"><img src=" " class="pull-left" style="margin-right:6px;"/> Register </a>
        <a class="btn btn-large" href="/users/login">
            <img src=" " class="pull-left" style="margin-right:6px"/> Login </a>
    </div>
</div>
<?php endif; ?>
