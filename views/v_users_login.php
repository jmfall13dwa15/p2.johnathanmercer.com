<h2>Log in</h2>

<form method='POST' action='/users/p_login'>

	<label>Email</label>
	<input type='text' name='email'><br>

	<label>Password</label>
	<input type='password' name='password'><br>
	
	<input type='Submit' value='Log in' class="btn">	

</form>

<?php if(isset($client_files_head)) echo $error; ?>
<div class="row-fluid status-bar">
    <div class="span12">
         <?php if(isset($error)): ?> 
        	<div class="alert alert-success" style= "display:inline" >
        <?php else: ?> 
        	<div class="alert alert-success" style= "display:none" >
    	<?php endif; ?>
         
    	<?php if(isset($error)): echo "<b>".$error."<b>"; ?>
    </div>
</div>