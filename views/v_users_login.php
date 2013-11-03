<h2>Log in</h2>

<form method='POST' action='/users/login'>

	<label>Email</label>
	<input type='text' name='email'><br>

	<label>Password</label>
	<input type='password' name='password'><br>
	
	<input type='Submit' value='Log in' class="btn">	

</form>


<div class="row-fluid status-bar">
    <div class="span12">
        <div class="alert alert-error" <?php if(!isset($errors)){ echo 'style = "display: none"';} ?> >
           <?php if(isset($errors)): ?>
	       	 Oopsie... 
           <?php endif; ?> 
           <br>
           <?php foreach($errors as $error): ?> 
		    	<?=$error?> <br>
           <?php endforeach ?>
        </div>
    </div>
</div>
