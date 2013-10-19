<h2>Sign Up</h2>

<form method='POST' action='/practice/signup'>

	First Name 
	<input type='text' name='first_name' value='<?php if(isset($_POST['first_name'])) echo $_POST['first_name']?>'><br>
	
	Last Name 
	<input type='text' name='last_name' value='<?php if(isset($_POST['last_name'])) echo $_POST['last_name']?>'><br>
	
	Email 
	<input type='text' name='email' value='<?php if(isset($_POST['email'])) echo $_POST['email']?>'><br>
	
	Password 
	<input type='password' name='password'><br>
	
	<input type='submit' value='Sign Up'>

	<?php if(isset($error)) echo $error; ?>	

</form>