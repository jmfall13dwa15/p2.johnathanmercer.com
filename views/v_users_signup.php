<!-- <h2>Sign Up</h2>
 -->
<form class="edit-user-form" method='POST' action='/users/signup'>

	<legend> Sign up </legend>
	<label>First Name</label>
	<input type='text' name='first_name'><br>
	<label>Last Name</label>
	<input type='text' name='last_name'><br>
	<label>Email</label>
	<input type='text' name='email'><br>
	<label>Password</label>
	<input type='password' name='password'><br><br>
	
	<input type='submit' value='Sign up' class="btn">

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
 
